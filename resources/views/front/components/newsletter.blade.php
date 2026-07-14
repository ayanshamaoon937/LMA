<?php

  $title = $props["title"] ?? "STAY CONNECTED WITH NATURE";
  $description = $props["description"] ?? "Be the first to hear about new glamping spots, seasonal offers, and inspiring stories from nature — no spam, just calm inspiration.";
  $placeholder = $props["placeholder"] ?? "Your email address";
  $privacyText = $props["privacyText"] ?? "We respect your privacy. Unsubscribe any time.";
  $className = $props["className"] ?? "";

  $safeTitle = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
  $safeDescription = htmlspecialchars($description, ENT_QUOTES, "UTF-8");
  $safePlaceholder = htmlspecialchars($placeholder, ENT_QUOTES, "UTF-8");
  $safePrivacyText = htmlspecialchars($privacyText, ENT_QUOTES, "UTF-8");
  $safeClassName = htmlspecialchars($className, ENT_QUOTES, "UTF-8");
  ?>
  <div
    class="bg-[#F8F8F8] lg:rounded-[20px] rounded-[10px] py-[20px] md:py-[40px] px-[25px] md:px-[60px] flex flex-col lg:flex-row items-center justify-between gap-12 <?= $safeClassName ?>">
    <div class="max-w-[709px]">
      <h2 class="2xl:text-heading-md text-heading-sm font-bold font-seasons uppercase tracking-[2%] text-primary leading-tight">
        <?= $safeTitle ?>
      </h2>
      <p class="mt-4 2xl:text-body-md text-body-sm font-openSauce text-[#737373] leading-relaxed">
        <?= $safeDescription ?>
      </p>
    </div>

    <div class="max-w-[396px] w-full">
      <form action="{{ route('newsletter.subscribe') }}" method="POST" class="ajax-form relative block w-full" id="newsletter-form" data-success-text="Thank you for subscribing to our newsletter!" data-reset="true">
        @csrf
        <div class="flex items-center w-full">
          <input type="email" name="email" required placeholder="<?= $safePlaceholder ?>" data-errors-container="#newsletter-email-error"
            class="flex-1 bg-white h-[52px] rounded-l-[8px] focus:outline-none text-body-sm px-[18px] placeholder:text-[#737373] text-text" />
          <button type="submit" aria-label="Subscribe" data-only-loader="true"
            class="bg-secondary text-white h-[52px] w-[48px] !rounded-r-[8px] flex items-center justify-center transition-all duration-300 transform active:scale-95 group hover:bg-secondary/90">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M15.7521 0.107346C15.9485 0.250203 16.0289 0.440679 15.9932 0.678774L13.7075 14.3931C13.6777 14.5657 13.5825 14.6996 13.4218 14.7948C13.3384 14.8425 13.2462 14.8663 13.145 14.8663C13.0795 14.8663 13.0081 14.8514 12.9307 14.8216L8.22533 12.902L5.56462 15.8216C5.45747 15.9466 5.31759 16.0091 5.14497 16.0091C5.06164 16.0091 4.99319 15.9972 4.93961 15.9734C4.82652 15.9318 4.73723 15.8603 4.67176 15.7591C4.60628 15.6639 4.57354 15.5568 4.57354 15.4377V11.402L0.359258 9.67877C0.139019 9.59544 0.0199718 9.43175 0.00211466 9.1877C-0.0157425 8.95556 0.0794956 8.77997 0.287829 8.66092L15.145 0.0894885C15.3533 -0.0355115 15.5557 -0.0295589 15.7521 0.107346ZM12.6985 13.4913L14.6718 1.67877L1.86819 9.0627L4.86819 10.2859L12.5735 4.58056L8.30569 11.6966L12.6985 13.4913Z"
                fill="white" />
            </svg>
          </button>
        </div>
        <div id="newsletter-email-error"></div>
      </form>
      <p class="mt-2 text-[14px] text-secondary text-center tracking-normal">
        <?= $safePrivacyText ?>
      </p>
    </div>
  </div>

@once
@push('scripts')
<script src="{{ asset('assets/js/ajax-form.js') }}"></script>
<script src="{{ asset('assets/js/form-validator.js') }}"></script>
@endpush
@endonce
