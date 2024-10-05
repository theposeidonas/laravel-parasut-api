<?php

namespace Theposeidonas\LaravelParasutApi\Models\Expenses;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Theposeidonas\LaravelParasutApi\ParasutV4;

/**
 * Çalışan Giderleri
 * https://apidocs.parasut.com/#tag/Employees
 */
class Employee extends ParasutV4
{
    /**
     * @var string
     */
    private string $serviceUrl;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct($config);
        $this->serviceUrl = $this->config['api_url'].$this->config['company_id'].'/employees';
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function index(array $parameters = []): array
    {
        Validator::validate($parameters, [
            'filter.name'        => 'nullable|string',
            'filter.email'       => 'nullable|string|email',
            'sort'               => 'nullable|string|in:id,balance,name,email,-id,-balance,-name,-email',
            'page.number'        => 'nullable|integer|min:1',
            'page.size'          => 'nullable|integer|min:1|max:25',
            'include'            => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl, $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function create($data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->post($this->serviceUrl.'?'.http_build_query($parameters), $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function show(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->get($this->serviceUrl.'/'.$id, $parameters);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $data
     * @param array $parameters
     * @return array
     */
    public function edit(string $id,array $data, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->put($this->serviceUrl.'/'.$id.'?'.http_build_query($parameters), $data);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @return array
     */
    public function delete(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->delete($this->serviceUrl.'/'.$id);
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function archive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/archive?'.http_build_query($parameters));
        return $this->handleResponse($response);
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return array
     */
    public function unarchive(string $id, array $parameters = []): array
    {
        Validator::validate($parameters, [
            'include' => 'nullable|string|in:category,managed_by_user,managed_by_user_role',
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->token,
            'Content-Type' => 'application/json',
        ])->patch($this->serviceUrl.'/'.$id.'/unarchive?'.http_build_query($parameters));
        return $this->handleResponse($response);
    }
}