<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if(!function_exists('base64_upload'))
{

    function fileUploadFormat($data){
        $allowedTypes = [
            "audio/mpeg" => "mp3",
            "audio/wav" => "wav",
            "video/mp4" => "mp4",
            "video/mkv" => "mkv",
            "image/gif" => "gif",
            "image/jpeg" => "jpg",
            "image/jpeg" => "jpg",
            "image/png" => "png",
            "image/webp" => "webp",
            "image/svg+xml" => "svg",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" => "xlsx",
            "application/vnd.ms-excel" => "xls",
            "text/csv" => "csv",
            "application/pdf" => "pdf",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "docx",
            "application/msword" => "doc",
            "application/vnd.ms-powerpoint" => "ppt",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation" => "pptx",
        ];

        return $allowedTypes[$data]?? null;

    }

    function fileUploadSave($data,$path,$accept = ['png','jpg','jpeg'], $column = 'image')
    {
        $fileType = explode(';base64,',$data);
        $fileType = explode('data:',$fileType[0]);
        $fileFormat = fileUploadFormat($fileType[1]);
        
        $base64_data = str_replace('data:'.$fileType[1].';base64,','',$data);
        $base64_data = str_replace(' ', '+', $base64_data);
                
        $defineRootPath = base_path('storage/app/public');

        $pathLast = strip_slash($defineRootPath.'/'.$path);

        if (!file_exists($pathLast)) {
            mkdir($pathLast, 0777,true);
        }
        
        $fileName = Str::random(16).'.'.$fileFormat;

        $pathData = $path.'/'.$fileName;

        Storage::disk('public')->put($pathData, base64_decode($base64_data));

        // file_put_contents($pathData, base64_decode($base64_data));

        $dataResult = Storage::url($path.'/'.$fileName);

        return $dataResult;
    }

    function fileUpload($data,$path,$accept = ['png','jpg','jpeg'], $column = 'image'){

        if(!is_array($data))
        {
            $fileType = explode(';base64,',$data);
            $fileType = explode('data:',$fileType[0]);
            $fileFormat = fileUploadFormat($fileType[1]);

            if(!preg_match("/data:([a-zA-Z]*)\/([a-zA-Z]*);base64,([^\"]*)/u", $data)){
                return [
                    'status' => false,
                    'errors' => [
                        "$column" => ["Format file tidak diketahui"]
                    ],
                ];
            }

            if(count($accept)){
            
                $acceptString = [];
                foreach($accept as $item){
                    $acceptString[] = '.'.$item;
                }
                $acceptStringText = implode(',',$acceptString);
    
                if(!in_array($fileFormat, $accept)){
                    return [
                        'status' => false,
                        'errors' => [
                            "$column" => ["Format file harus $acceptStringText"]
                        ],
                    ];
                }
            }

            if($dataResult = fileUploadSave($data,$path,$accept,$column))
            {
                return [
                    'status' => true,
                    'data' => $dataResult
                ];
            }

            return [
                'status' => false,
                'message' => "Gagal mengupload file"
            ];
        }

        $result = [];
        
        foreach($data as $item){
            
            $fileType = explode(';base64,',$item);
            $fileType = explode('data:',$fileType[0]);
            $fileFormat = fileUploadFormat($fileType[1]);

            if(!preg_match("/data:([a-zA-Z]*)\/([a-zA-Z]*);base64,([^\"]*)/u", $item)){
                return [
                    'status' => false,
                    'errors' => [
                        "$column" => ["Format file tidak diketahui"]
                    ],
                ];
            }

            if(count($accept)){
            
                $acceptString = [];
                foreach($accept as $acc){
                    $acceptString[] = '.'.$acc;
                }
                $acceptStringText = implode(',',$acceptString);
    
                if(!in_array($fileFormat, $accept)){
                    return [
                        'status' => false,
                        'errors' => [
                            "$column" => ["Format file harus $acceptStringText"]
                        ],
                    ];
                }
            }

            $result[] = fileUploadSave($item,$path,$accept,$column);

        }

        if(count($result))
        {
            return [
                'status' => true,
                'data' => $result
            ];
        }

        return [
            'status' => false,
            'message' => "Gagal mengupload file"
        ];
        

    }

}