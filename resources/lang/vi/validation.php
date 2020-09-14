<?php

return [
    'required' => ':attribute không được bỏ trống.',
    'regex' => ':attribute không đúng định dạng',
    'max' => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file' => 'The :attribute không được lớn hơn :max kilobytes.',
        'string' => 'The :attribute không được lớn hơn :max ký tự.',
        'array' => 'The :attribute không được lớn hơn :max thành phần',
    ],
    'image' => ':attribute phải là ảnh.',
    'numeric' => ':attribute phải là số.',
    'email' => ':attribute phải đúng định dạng email',
    'unique' => ':attribute đã được đăng ký',
];
