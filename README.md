This is a simple wordpress plugin that allows you to reference small snippets of content via shortcode. An example would be, let's say you had a small callout box on several pages of your site that had your contact info; phone number, email, name, address, etc. Later, you decide to change the address or phone number of your business. You would then have to search through each page and change your contact info one page at a time. Wouldn't it be nice if you only had to change it in one place? That's where this plugin comes in handy! To do it, first create a new static bloc from the Static Blox menu of the wordpress dashboard and put your contact info in it. You can then use either the slug (changeable) or the id of the static bloc in your shortcode. Put the shortcode with either the name or id of your static bloc on any pages that support shortcodes or in php via `do_shortcode()`.

### Example
```
[static_bloc name="contact-info"]
[static_bloc id="10"]
```
```php
echo do_shortcode('[static_bloc name="contact-info"]');
```
`name` = slug of static bloc  
`id` = post id of static bloc  
