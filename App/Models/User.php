<?php

namespace App\Models;

use Lucent\Model\Column;
use Lucent\Model\ColumnType;
use Lucent\Model\Model;

/**
 * Example model.
 *
 * Lucent maps each model to a database table named after the class
 * (no pluralisation). Columns are declared with the #[Column] attribute.
 *
 * Run `vendor/bin/lucent migration make App/Models/User` to create the
 * matching table. This class is a starting point — extend it or delete it
 * as you build your application.
 */
class User extends Model
{
    #[Column(ColumnType::INT, primaryKey: true, autoIncrement: true)]
    public private(set) ?int $id;

    #[Column(ColumnType::VARCHAR, length: 255)]
    protected string $name;

    #[Column(ColumnType::VARCHAR, length: 255, unique: true)]
    protected string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}