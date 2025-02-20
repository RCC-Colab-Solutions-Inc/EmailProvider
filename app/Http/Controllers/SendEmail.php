<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailAccountProvider;

use App\Mail\SendEmailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
class SendEmail extends Controller
{

    public function sendEmail(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'applicationid' => 'required|integer',
            'emailreceiver' => 'required|email',
            'emailsubject' => 'required|string',
            'emailbody' => 'required|string',
        ]);

        // Retrieve the email account provider details based on the applicationid
        $emailAccountProvider = EmailAccountProvider::where('applicationid', $validated['applicationid'])->first();

        // If the email provider is not found, return a 404 response
        if (!$emailAccountProvider) {
            return response()->json(['message' => 'Email Account Provider not found'], 404);
        }

        // Log for debugging (optional)
        Log::info('Email Account Provider found:', ['applicationid' => $validated['applicationid'], 'provider' => $emailAccountProvider]);

        // Set the email configuration dynamically using the provider's credentials
        Config::set('mail.mailers.smtp.host', $emailAccountProvider->host);
        Config::set('mail.mailers.smtp.port', $emailAccountProvider->port);
        Config::set('mail.mailers.smtp.encryption', $emailAccountProvider->encryption);
        Config::set('mail.mailers.smtp.username', $emailAccountProvider->username);
        Config::set('mail.mailers.smtp.password', $emailAccountProvider->password);
        Config::set('mail.from.address', $emailAccountProvider->from);
        Config::set('mail.from.name', $emailAccountProvider->fromname);
        //set the cc and bcc
        Config::set('mail.cc.address', $emailAccountProvider->carboncopy);
        Config::set('mail.bcc.address', $emailAccountProvider->blindcarboncopy);

        // Send the email using the SendEmailNotification mailable with cc and bcc
        try {
            //send the email with cc and bcc
            Mail::to($validated['emailreceiver'])->cc($emailAccountProvider->carboncopy)->bcc($emailAccountProvider->blindcarboncopy)->send(new SendEmailNotification($validated['emailsubject'], $validated['emailbody']));
            return response()->json(['message' => 'Email sent successfully!']);
            

            // Mail::to($validated['emailreceiver'])->send(new SendEmailNotification($validated['emailsubject'], $validated['emailbody']));
            // return response()->json(['message' => 'Email sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Email sending failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
