<?php

namespace App\Services;

use App\Models\UserProfiles;

class ProfileService
{
  /**
   * プロフィール編集用データ取得
   */
  public function getProfileForEdit(int $userId): ?UserProfiles
  {
    // user_id が PK なので find() で OK
    return UserProfiles::find($userId);
  }

  /**
   * プロフィール更新（新規作成 or 更新）
   */
  public function updateProfile(int $userId, array $data): UserProfiles
  {
    $invoiceEnabled = (bool)($data['invoice_enabled'] ?? false);

    // インボイス無効なら番号は必ず null にする
    $invoiceNumber = $invoiceEnabled
      ? ($data['invoice_number'] ?? null)
      : null;

    return UserProfiles::updateOrCreate(
      ['user_id' => $userId],
      [
        // DB デフォルトで app_role = 'user' / tax_filing_method = 'NA' があるので
        // 未入力ならそのまま使う
        'tax_filing_method' => $data['tax_filing_method'] ?? 'NA',
        'invoice_enabled'   => $invoiceEnabled,
        'invoice_number'    => $invoiceNumber,
        'business_name'     => $data['business_name'] ?? null,
      ]
    );
  }
}