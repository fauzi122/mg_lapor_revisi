<?php

namespace App\Traits;

use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait LogTrait
{
    use SentEmailTrait;
    
    protected static $oldValuesCache = [];
    protected static $newValuesCache = [];

    public static function bootLogTrait()
    {
        // Simpan old & new values sebelum update
        static::updating(function ($model) {
            self::$oldValuesCache[$model->getKey()] = $model->getOriginal();
            self::$newValuesCache[$model->getKey()] = $model->getDirty();
        });

        static::created(function ($model) {
            static::storeLog($model, static::class, 'CREATED');
        });

        static::updated(function ($model) {
            // Kirim email saat BU men-submit laporan
            if (Auth::user()->role === "BU" && $model->getOriginal()['status'] == '0' && $model->status == "1") {
                // $class = Str::of(class_basename($model))->replace('_', ' ');
                // $receiver = Auth::user()->email;
                $receiver = "mnja2701@gmail.com";
                $model->emailNotif($receiver,"SUBMIT");
            }
            // Kirim email saat Badan Usaha mengirim perbaikan revisi
            if (Auth::user()->role === "BU" && $model->getOriginal()['status'] == '2' && $model->status == "1") {
                // $class = Str::of(class_basename($model))->replace('_', ' ');
                // $receiver = $model->user->email;
                $receiver = "mnja2701@gmail.com";
                $model->emailNotif($receiver,"PERBAIKAN");
            }
            // Kirim email saat Evaluator mengirim revisi
            if (Auth::user()->role === "ADM") {
                // $class = Str::of(class_basename($model))->replace('_', ' ');
                // $model->load('user'); // preload relasi user
                // $receiver = $model->user->email;
                $receiver = "mnja2701@gmail.com";
                $model->emailNotif($receiver,"REVISI");
            }
            static::storeLog($model, static::class, 'UPDATED');
        });

        static::deleted(function ($model) {
            static::storeLog($model, static::class, 'DELETED');
        });
    }

    public static function getTagName($model)
    {
        return !empty($model->tagName) ? $model->tagName : Str::title(Str::snake(class_basename($model), ' '));
    }

    public static function storeLog($model, $modelPath, $action)
    {
        $oldValues = null;
        $newValues = null;

        if ($action === 'CREATED') {
            $newValues = $model->getAttributes();
        } elseif ($action === 'UPDATED') {
            $oldValues = self::$oldValuesCache[$model->getKey()] ?? [];
            $newValues = self::$newValuesCache[$model->getKey()] ?? [];
        } elseif ($action === 'DELETED') {
            $oldValues = $model->getAttributes();
        }

        $subject = static::getTagName($model);

        $systemLog = new Log();
        $systemLog->subject = $subject . ':' . $action;
        $systemLog->action = $action;

        if (Auth::check()) {
            $systemLog->bu_id = Auth::user()->id;
            $systemLog->bu_name = Auth::user()->name;
        }

        $systemLog->method = request()->method();
        $systemLog->old_properties = json_encode($oldValues);
        $systemLog->properties = json_encode($newValues);
        $systemLog->url = request()->path();
        $systemLog->description = 'Data ' . $subject . ' [' . $action . ']';
        $systemLog->ip_address = request()->ip();
        $systemLog->hostname = gethostname();
        $systemLog->informasi_peramban = request()->header('User-Agent');
        $systemLog->save();
    }
}
