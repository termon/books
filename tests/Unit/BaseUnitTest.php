<?php

namespace Tests\Unit;

use App\Enums\Role;
use PHPUnit\Framework\TestCase;

class BaseUnitTest extends TestCase
{

    // Unit Test

    public function test_that_role_enum_has_three_cases(): void
    {
        // act
        $admin = Role::ADMIN;
        $author = Role::AUTHOR;
        $guest = Role::GUEST;

        // assert
        $this->assertEquals(Role::ADMIN, $admin);
        $this->assertEquals(Role::AUTHOR, $author);
        $this->assertEquals(Role::GUEST, $guest);

        $this->assertNotEquals(Role::ADMIN, $author);
        $this->assertNotEquals(Role::ADMIN, $guest);
        $this->assertNotEquals(Role::AUTHOR, $admin);
        $this->assertNotEquals(Role::AUTHOR, $guest);
        $this->assertNotEquals(Role::GUEST, $admin);
        $this->assertNotEquals(Role::GUEST, $author);
    }


    // Integration test to verify Role has EnumOptions trait
    public function test_that_role_enum_has_options_trait(): void
    {
        // act
        $options = Role::options();

        // assert
        $this->assertIsArray($options);
        $this->assertCount(3, array_count_values($options));
    }
}
