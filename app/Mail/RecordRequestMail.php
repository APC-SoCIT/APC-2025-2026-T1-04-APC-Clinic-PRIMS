<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\DentalRecord;
use App\Models\Patient;


class RecordRequestMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $record;
    public $type; // 'medical' or 'dental'
    public $url;

    public function __construct($record, $type)
    {
        $this->record = $record;
        $this->type = $type;

        $this->url = $type === 'dental'
            ? url('/staff/dental-records/' . $record->id)
            : url('/medical-records/' . $record->id);
    }

    public function build()
    {
        $subject = $this->type === 'dental'
            ? 'Dental Record Print Request'
            : 'Medical Record Print Request';

        return $this->subject($subject)
                    ->view('emails.record-request-mail');
    }

}
