<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;

interface UserInterface
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param int $userId
     * @return mixed
     */
    public function get(int $userId);

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * @param Request $request
     * @param int $userId
     * @return mixed
     */
    public function update(Request $request, int $userId);

    /**
     * @param int $userId
     * @return mixed
     */
    public function delete(int $userId);
}
