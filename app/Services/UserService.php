<?php

namespace App\Services;

use App\Models\User;
use App\Interfaces\IUserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService implements IUserService {
  public function getAdminMenuFilterUsers($validated): LengthAwarePaginator {

    $users = User::when(
      isset($validated['userId']),
      function ($querry) use ($validated) {
        return $querry->where('id', 'REGEXP', $validated['userId']);
      }
    )->when(
      isset($validated['name']),
      function ($querry) use ($validated) {
        return $querry->where('name', 'REGEXP', $validated['name']);
      }
    )->when(
      isset($validated['email']),
      function ($querry) use ($validated) {
        return $querry->where('email', 'REGEXP', $validated['email']);
      }
    )->when(
      isset($validated['status']) && ($validated['status'] != 0),
      function ($querry) use ($validated) {
        return $querry->where('user_status_id', '=', $validated['status']);
      }
    )->where(
      'is_admin',
      '=',
      isset($validated['isAdmin'])
    )->paginate(10);

    return $users;
  }

  public function getLatest10UsersRegistration(): Collection {
    return User::all()->sortByDesc('created_at')->take(10);
  }

  public static function getAllIdRegexpFromName($userName): string {
    $users = User::where('name', 'REGEXP', $userName)->get();

    $ids = "";

    if (count($users) > 0) {
      foreach ($users as $user) {

        if (strlen($ids) > 0) {
          $ids = $ids . '|';
        }

        $ids = $ids . $user->id;
      }
    } else {
      $ids = " ";
    }

    return $ids;
  }
}
