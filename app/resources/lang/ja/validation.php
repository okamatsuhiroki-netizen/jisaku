<?php

return [
    'required' => ':attribute は必須項目です。',
    'email'    => ':attribute は正しいメールアドレス形式で入力してください。',
    'min' => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],
    'confirmed' => ':attribute が一致しません。',

    'attributes' => [
        'email'    => 'メールアドレス',
        'content' =>'文章',
        'comment' =>'コメント',
        'password' => 'パスワード',
    ],
];
