<?php
namespace App\Mail;

use App\Models\LulusanModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UndanganFormLulusan extends Mailable
{
    use Queueable, SerializesModels;

    public $alumni;
    public $token;

    public function __construct(LulusanModel $alumni, $token)
    {
        $this->alumni = $alumni;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('emails.undangan_lulusan')
            ->with([
                'alumni' => $this->alumni,
                'url' => route('lulusan.form-lulusan', ['token' => $this->token]),
            ]);
    }
}
