<?php

namespace App\Validacao\Rules;

use Rakit\Validation\Helper;
use Rakit\Validation\MimeTypeGuesser;
use Rakit\Validation\Rule;
use Rakit\Validation\Rules\Traits\FileTrait;
use Rakit\Validation\Rules\Traits\SizeTrait;
use Rakit\Validation\Rules\UploadedFile;

class ValidUploadFileRule extends UploadedFile
{
    public function check($value): bool
    {
        $minSize = 0;
        $maxSize = $_ENV['TAMANHO_MAXIMO_ARQUIVO_CAMPANHA'];
        $allowedTypes = explode(",", $_ENV['FORMATOS_ARQUIVO_CAMPANHA']);
        if ($allowedTypes) {
            $or = $this->validation ? $this->validation->getTranslation('or') : 'or';
            $this->setParameterText('allowed_types', Helper::join(Helper::wraps($allowedTypes, "'"), ', ', ", {$or} "));
        }

        if ($this->isEmptyValueFromUploadedFiles($value)) {
            $this->setMessage('O ArquivoCampanha não pode ser vazio');
            return false;
        }

        // below is Required rule job
        if (!$this->isValueFromUploadedFiles($value) or $value['error'] == UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (!$this->isUploadedFile($value)) {
            return false;
        }
        // just make sure there is no error
        if ($value['error']) {
            return false;
        }
       
        if ($minSize) {
            $bytesMinSize = $this->getBytesSize($minSize);
            if ($value['size'] < $bytesMinSize) {
                $this->setMessage('The :attribute file is too small, minimum size is :min_size');
                return false;
            }
        }

        if ($maxSize) {
            $bytesMaxSize = $this->getBytesSize($maxSize);
            if ($value['size'] > $bytesMaxSize) {
                $this->setMessage('The :attribute file is too large, maximum size is :max_size');
                return false;
            }
        }
        if (!empty($allowedTypes)) {
            $guesser = new MimeTypeGuesser;
            $ext = $guesser->getExtension($value['type']);
            unset($guesser);
            if (!$ext || !in_array($ext, $allowedTypes)) {
                $this->setMessage('A extensão do :attribute deve ser :allowed_types');
                return false;
            }
        }

        return true;
    }

    public function isEmptyValueFromUploadedFiles($value): bool
    {
        if (!is_array($value)) {
            return false;
        }
        if(isset($value["name"])) {
            $value = [$value];
        }
        $keys = ['name', 'type', 'tmp_name', 'size'];
        foreach ($keys as $key) {
            if (count(array_filter(array_column($value, $key))) == 0) {
                return true;
            }
        }

        return false;
    }
}
