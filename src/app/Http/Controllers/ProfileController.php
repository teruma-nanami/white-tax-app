<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  public function __construct(
    private readonly ProfileService $profileService
  ) {}

  /**
   * プロフィール編集画面表示
   */
  public function edit()
  {
    $user    = Auth::user();
    $profile = $this->profileService->getProfileForEdit($user->id);

    return view('profile.edit', [
      'user'    => $user,
      'profile' => $profile,
    ]);
  }

  /**
   * プロフィール更新
   */
  public function update(ProfileRequest $request)
  {
    $userId = Auth::id();

    $this->profileService->updateProfile(
      userId: $userId,
      data: $request->validated()
    );

    return redirect()
      ->route('profile.edit')
      ->with('success', 'プロフィールを更新しました。');
  }
}