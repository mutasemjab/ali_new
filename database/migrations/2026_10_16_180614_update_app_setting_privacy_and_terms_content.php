<?php

use App\Models\AppSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $privacyPolicy = <<<'TEXT'
FlyerAll, ("we", "us", or "our") respects your privacy and is committed to protecting it through this Privacy Policy. This policy explains how we collect, use, disclose, and safeguard your information when you visit: https://flyerall.net/ or engage with our services, including SMS communications.

1. Information We Collect

We may collect the following information:

Personal Information: Name, email address, phone number, mailing address.

Mobile Information: Phone number provided for SMS communications.

Usage Data: IP address, browser type, pages visited, time spent on pages.

Cookies & Tracking Data: See Section 6 below.

2. How We Use Your Information

We use your information to:

Provide and manage our services

Communicate with you regarding your account or inquiries

Send SMS messages you have opted into

Improve our website and services

Comply with legal obligations

3. SMS Communications & Consent

By providing your mobile phone number and opting in, you expressly consent to receive automated and non-automated SMS messages from FlyerAll, including but not limited to:

Customer support messages

Service updates and notifications

Appointment reminders

Promotional and marketing messages

Message Frequency: May vary.

Message & Data Rates: Standard message and data rates may apply.

Opt-Out: You may opt out at any time by replying STOP to any message. Reply HELP for assistance.

Consent Not Required for Purchase: Your consent to receive SMS messages is not a condition of purchasing any goods or services.

4. Sharing of Information

We do not sell, rent, or share your personal information with third-party companies for their marketing purposes.

No mobile information will be shared with third parties/affiliates for marketing/promotional purposes. Information sharing to subcontractors in support services, such as customer service, is permitted. All other use case categories exclude text messaging originator opt-in data and consent; this information will not be shared with any third parties.

5. Data Security

We implement reasonable administrative, technical, and physical safeguards designed to protect your information. However, no method of transmission over the internet is 100% secure.

6. Cookies & Tracking Technologies

We use cookies and similar tracking technologies to:

Analyze website traffic and usage

Improve user experience

Understand user behavior

You may control cookie settings through your browser preferences. Disabling cookies may affect website functionality.

7. Your Rights & Choices

You have the right to:

Access, correct, or delete your personal information

Opt out of marketing communications

Withdraw SMS consent at any time by replying STOP

To exercise these rights, contact us using the information below.

8. Children's Privacy

Our services are not intended for individuals under the age of 18. We do not knowingly collect information from minors.

9. Contact Us

If you have questions about this Privacy Policy or our SMS practices, contact us at:

Email: support@flyerall.net
TEXT;

        $termsOfService = <<<'TEXT'
By accessing or using our website and services, including SMS communications, you agree to these Terms of Use.

1. SMS Program Description

FlyerAll, offers SMS messaging programs that may include:

Account notifications

Customer support communications

Appointment reminders

Promotional offers and updates (where consent is provided)

2. Opt-In & Opt-Out

By opting into our SMS program, you agree to receive text messages as described above.

Opt-Out: Reply STOP at any time to unsubscribe.

Help: Reply HELP or contact: support@flyerall.net

3. Message Frequency & Costs

Message frequency may vary. Message and data rates may apply depending on your carrier plan.

4. Carrier Disclaimer

Wireless carriers are not liable for delayed or undelivered messages.

5. Eligibility (18+)

You must be at least 18 years old to participate in our SMS programs.

6. Customer Support

For SMS-related support, contact:

Email: support@flyerall.net

7. Privacy Policy

Your participation in our SMS program is subject to our Privacy Policy. By opting in, you agree to the collection and use of information as described therein.

8. Modifications

We reserve the right to modify these Terms at any time. Continued use of the services constitutes acceptance of updated Terms.

9. Governing Law

These Terms are governed by the laws of the United States.
TEXT;

        AppSetting::current()->update([
            'privacy_policy' => $privacyPolicy,
            'terms_of_service' => $termsOfService,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Content-only change — intentionally not reversible to a prior version.
    }
};
