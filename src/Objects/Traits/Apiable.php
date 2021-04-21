<?php

namespace Marshmallow\TranslatedCom\Objects\Traits;

use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\TranslatedCom\Models\Order;
use Marshmallow\TranslatedCom\Objects\Method;
use Marshmallow\TranslatedCom\Models\Confirmation;
use Marshmallow\TranslatedCom\Objects\OutputFormat;
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

trait Apiable
{
    protected $cid;

    protected $p;

    protected $of;

    protected $df;

    protected $f;

    protected $sandbox;

    public function run(): Response
    {
        $order = $this->storeRequest();
        $response = Http::get(config('translated-com.path'), $this->getFullRequestDataArray());
        $response_array = $this->forceResponseToArray($response);

        if ($response_array['code'] == 0) {
            throw new Exception($response_array['message'], 1);
        }
        $this->storeResponse($order, $response);
        return $response;
    }

    protected function storeRequest()
    {
        if (!TranslatedCom::shouldStore()) {
            return null;
        }

        if ($this->f == Method::QUOTE) {
            return Order::create($this->getStorableDataArray([
                'model_type', 'model_id', 'column', 'flex'
            ]));
        } else if ($this->f == Method::CONFIRM) {
            return Confirmation::create($this->getStorableDataArray());
        }
    }

    protected function storeResponse(Model $model = null, Response $response): ?Model
    {
        if (!$model) {
            return null;
        }

        $array_response = $this->forceResponseToArray($response);

        if ($this->f == Method::QUOTE) {
            $model->update([
                'code' => intval($array_response['code']),
                'message' => $array_response['message'],
                'delivery_date' => $array_response['delivery_date'],
                'words' => intval($array_response['words']),
                'total' => floatval($array_response['total']),
                'pid' => intval($array_response['pid']),
            ]);
        } else if ($this->f == Method::CONFIRM) {
            $model->update([
                'code' => intval($array_response['code']),
                'message' => $array_response['message'],
            ]);
        }
        return $model->fresh();
    }

    protected function forceResponseToArray(Response $response)
    {
        if ($this->of == OutputFormat::JSON) {
            return $response->json();
        }

        $response_array = explode("\n", $response->body());
        return [
            'code' => intval($response_array[0]),
            'message' => $response_array[1],
            'delivery_date' => $response_array[2],
            'words' => intval($response_array[3]),
            'total' => $response_array[4],
            'pid' => intval($response_array[5]),
        ];
    }

    protected function getStorableDataArray($extra_data = []): array
    {
        $ignore_while_storing = [
            'cid', 'p',
        ];
        return collect($this->getFullRequestDataArray($extra_data))->reject(function ($value, $key) use ($ignore_while_storing) {
            return in_array($key, $ignore_while_storing);
        })->toArray();
    }

    protected function getFullRequestDataArray($extra_data = []): array
    {
        $data = [
            'cid' => $this->cid,
            'p' => $this->p,
            'of' => $this->of,
            'f' => $this->f,
            'sandbox' => $this->sandbox,
        ];

        if ($data['sandbox'] == 0) {
            unset($data['sandbox']);
        }

        foreach ($extra_data as $column) {
            $data[$column] = $this->{$column};
        }

        return array_merge($data, $this->getRequestDataArray());
    }

    public function setUsername(string $username): self
    {
        $this->cid = $username;
        return $this;
    }

    public function setFunction(string $function): self
    {
        $this->f = $function;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->p = $password;
        return $this;
    }

    public function setOutputFormat(string $output_format = null): self
    {
        $this->of = $output_format;
        return $this;
    }

    public function setDataFormat(string $data_format): self
    {
        $this->df = $data_format;
        return $this;
    }

    public function setSandbox(bool $sandbox): self
    {
        $this->sandbox = ($sandbox) ? 1 : 0;
        return $this;
    }

    public abstract function getRequestDataArray(): array;
}
