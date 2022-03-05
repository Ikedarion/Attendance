<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\DB;
use Throwable;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        try {
            DB::beginTransaction();

            $contact = $request->only(['name', 'email', 'tel', 'content']);
            Contact::create($contact);

            Mail::to($request->email)->send(new ContactMail($contact));

            DB::commit();

            return response()->json([
                'message' => 'お問い合わせが完了しました'
            ]);
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }
}
