# منبع محتوای مطالب

یک پلاگین ساده برای وردپرس که امکان ثبت لینک و نام منبع محتوا را در صفحه ویرایش نوشته‌ها اضافه می‌کند و در صورت تکمیل بودن اطلاعات، منبع را در انتهای مطلب نمایش می‌دهد.

## امکانات

- افزودن فیلد لینک منبع به نوشته‌ها
- افزودن فیلد نام منبع به نوشته‌ها
- نمایش خودکار منبع در انتهای محتوا
- باز شدن لینک منبع در تب جدید
- استفاده از `noopener noreferrer` برای امنیت بیشتر

## نصب

1. پوشه `content-source-meta` را داخل مسیر زیر قرار دهید:

`wp-content/plugins/`

2. پلاگین را از پیشخوان وردپرس فعال کنید.

## توسعه

برای تغییر متن نمایشی منبع، مقدار داخل تابع `display_source` را ویرایش کنید.

---

# Content Source Meta

A simple WordPress plugin that adds source name and source URL fields to post editor pages and displays the source at the end of the post content.

## Features

- Adds a source URL field to posts
- Adds a source name field to posts
- Automatically displays the source below the post content
- Opens the source link in a new tab
- Uses `noopener noreferrer` for better security

## Installation

1. Upload the `content-source-meta` folder to:

`wp-content/plugins/`

2. Activate the plugin from the WordPress dashboard.

## Development

To change the displayed source text, edit the output inside the `display_source` method.
