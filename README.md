[![Build Status](https://travis-ci.org/AthensFramework/sendgrid.svg)](https://travis-ci.org/AthensFramework/sendgrid)
[![Code Climate](https://codeclimate.com/github/AthensFramework/sendgrid/badges/gpa.svg)](https://codeclimate.com/github/AthensFramework/sendgrid)
[![Test Coverage](https://codeclimate.com/github/AthensFramework/sendgrid/badges/coverage.svg)](https://codeclimate.com/github/AthensFramework/sendgrid/coverage)
[![Latest Stable Version](https://poser.pugx.org/athens/sendgrid/v/stable)](https://packagist.org/packages/athens/sendgrid)

SendGrid
===============
Send your Athens framework emails using your SendGrid account.

By default, the Athens framework uses the Php command `send` to deliver emails. If you have a SendGrid account, you can use this package to send your emails using SendGrid instead.

Use
---

Because this package has depends on multiple other packages, we strongly recommend installing it using [Composer](https://www.getcomposer.org). Add `athens/sendgrid` to your your `composer.json`:

```
"require": {
        ...
        "athens/sendgrid": "0.*",
        ...
    },
```

Then [update/install your Composer dependencies](https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies).

If you haven't already done so, create a SendGrid [API key](https://app.sendgrid.com/settings/api_keys). Paste that into your `local_settings.php`:

```
...
define('SENDGRID_API_KEY', 'mybiglongsendgridapikey');
...
```

Now define your default emailer in `setup.php`:

```
...
use Athens\Core\Etc\Settings;
...
Settings::setDefaultEmailerClass('Athens\SendGrid\Emailer');
...
```

That's it! If you provided the correct API key, your Athens emails are now being sent with SendGrid! Check your SendGrid dashboard to confirm.

Getting Involved
----------------

Feel free to open pull requests or issues. [GitHub](https://github.com/AthensFramework/sendgrid) is the canonical location of this project.

Here's the general sequence of events for code contribution:

1. Open an issue in the [issue tracker](https://github.com/AthensFramework/sendgrid/issues/).
2. In any order:
  * Submit a pull request with a **failing** test that demonstrates the issue/feature.
  * Get acknowledgement/concurrence.
3. Revise your pull request to pass the test in (2). Include documentation, if appropriate.
