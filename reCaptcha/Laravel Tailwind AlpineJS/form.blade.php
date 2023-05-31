@if(session()->has('success'))
    <div class="alert alert-success bg-[#d4ecce] border border-[#28a745] text-[#28a745] p-4 mb-8 text-sm">
        <p><i class="fa fa-check-circle"></i> Thank you, your message has been sent.</p>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger bg-red-100 text-red-600 p-4 mb-8 border border-red-600 text-sm">
        <p class="mb-3"><i class="fa fa-info-circle"></i> Please take care to fill out the form as required:</p>
        <ul>
            @foreach ($errors->all() as $e)
                <li>- {{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('contact.submit') }}" method="POST" x-data="contact" id="contactForm">

    @csrf

    <input type="text" name="name" placeholder="Your name *" class="contact-input mb-4" >
    <input type="email" name="email" placeholder="Email address *" class="contact-input mb-4">
    <input type="text" name="phone_number" placeholder="Contact number *" class="contact-input mb-4">
    <textarea name="message" placeholder="Write your message here..." class="contact-input mb-4" id="" cols="30" rows="10"></textarea>

    <input type="hidden" name="token" id="g-token">

    <button @click="submit" class="pt-btn pt-btn-orange pt-btn-text-sm g-recaptcha" type="button" data-sitekey="reCAPTCHA_site_key" data-callback="onSubmit" data-action="submit">
        Submit <i class="fa fa-arrow-right-long ml-2" aria-hidden="true"></i>
    </button>

</form>

<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.key') }}"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('contact', () => ({

            submit() {
            
            grecaptcha.ready(() => {
                grecaptcha.execute('{{ config('services.google.recaptcha.key') }}', {action: 'contact'}).then((token) => {
                        document.getElementById("g-token").value = token;
                        document.getElementById("contactForm").submit();
                });
            });
            }
        }))
    })
</script>