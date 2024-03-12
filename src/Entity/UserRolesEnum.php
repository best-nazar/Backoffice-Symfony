<?php

namespace App\Entity;

use App\Entity\User;

enum UserRolesEnum: string {
    case ROLE_USER = User::DEFAULT_ROLE;
    case ROLE_ADMIN = User::ROLE_ADMIN;
} 
