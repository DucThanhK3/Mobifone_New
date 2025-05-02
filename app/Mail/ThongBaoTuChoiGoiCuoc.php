<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThongBaoTuChoiGoiCuoc extends Mailable
{
    use Queueable, SerializesModels;

    public $dangKy;

    public function __construct($dangKy)
    {
        $this->dangKy = $dangKy;
    }

    public function build()
    {
        return $this->subject('Thông báo từ chối gói cước')
                    ->view('emails.thong_bao_tu_choi')
                    ->with([
                        'ten_goi' => optional($this->dangKy->goiCuoc)->ten_goi ?? 'Không xác định',
                        'so_dien_thoai' => optional($this->dangKy->soDienThoai)->so_dien_thoai ?? 'Không xác định',
                        'ngay_dang_ky' => $this->dangKy->created_at->format('d/m/Y H:i'),
                    ]);
    }
}