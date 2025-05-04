<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoiCuocDuyetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dangKy;
    protected $viewName;

    public function __construct($dangKy, $viewName)
    {
        $this->dangKy = $dangKy;
        $this->viewName = $viewName;
    }

    public function build()
    {
        $subject = $this->dangKy->trang_thai === 'approved' 
            ? 'Đăng ký gói cước được duyệt' 
            : 'Đăng ký gói cước bị từ chối';

        return $this->subject($subject)
                    ->view($this->viewName)
                    ->with([
                        'ten_goi' => optional($this->dangKy->goiCuoc)->ten_goi ?? 'Không xác định',
                        'so_dien_thoai' => optional($this->dangKy->soDienThoai)->so ?? 'Không xác định',
                        'ngay_dang_ky' => $this->dangKy->created_at->format('d/m/Y H:i'),
                        'trang_thai' => $this->dangKy->trang_thai,
                    ]);
    }
}