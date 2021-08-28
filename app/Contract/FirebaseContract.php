<?php

namespace App\Contract;

/**
 * Interface BaseContract
 * @package App\Contracts
 */
interface FirebaseContract
{
    /**
     * Create a model instance
     * @param array $attributes
     * @return mixed
     */
    public function createUser($data);

    /**
     * Update a model instance
     * @param array $attributes
     * @param int $id
     * @return mixed
     */
    public function updateUser($data, string $id);

    /**
     * Return all model rows
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function showUser(string $id);

    public function disableUser(string $id);

    public function enableUser(string $id);

    public function getUser(string $id);

    /**
     * Find one by ID
     * @param int $id
     * @return mixed
     */
    public function deleteUser(string $id);

    /**
     * Find one by ID or throw exception
     * @param int $id
     * @return mixed
     */
    public function createLoan($data);

    /**
     * Find based on a different column
     * @param array $data
     * @return mixed
     */
    public function updateLoan($data, string $id);

    /**
     * Find one based on a different column
     * @param array $data
     * @return mixed
     */
    public function deleteLoan(string $id);
}