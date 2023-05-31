Route::post('/contact', function ( Request $request ) {

$validated = $request->validate([
    'name' => 'required|string',
    'email' => 'required|email',
    'phone_number' => 'required|string',
    'message' => 'required|string',
    'token' => 'required'
]);

Notification::route('mail', env('MAIL_FROM_ADDRESS') ?? 'info@trsdesign.com' )->notify(new ContactSent( $validated ));

return back()->with('success', 'Your message has been sent!');

return redirect()->back();

})->name('contact.submit');