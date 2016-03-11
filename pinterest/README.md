# Steve's Pinterest API for PHP

Hey!  Thanks for using my Pinterest API for PHP!

This PHP class will make it easy to post pins to your Pinterest board
from any PHP script.  It's a wrapper around the undocumented Pinterest
APIs, with enough functionality to log into your account, get your
list of pinboards, pin and repin, all with a few simple PHP method
calls.

You can also save your login state between sessions, so you don't have
to re-authenticate every time you want to post a few more pins.

## License

I'm releasing this code under the GPLv3.

If you really can't abide by the terms of the GPLv3, contact me and we
can work out a proprietary license for your specific needs.


## Dependencies

This API uses the CURL module and PHP 5.3 or above.


## How does it work?

Include the class in your PHP program, by whatever means you prefer.

Then, instantiate a Pinterest object and log in:

    $p = new Pinterest();
    $p->login("mypinterestlogin", "mypinterestpassword");

Next, get your list of boards:

    $p->get_boards();

In this example, this isn't actually necessary--when you're logging
into a new session, the boards are retrieved automatically.  If you're
restoring an old session, though, you'll want to retrieve the boards
before doing anything, in case their IDs have changed.

Now, prepare the pin:

    $p->pin_url = "http://yellow5.com";
    $p->pin_description = "My awesome pin";
    $p->pin_image_preview = $p->generate_image_preview("compot.jpg");

The image preview works on either a local file, or a file that PHP can
retrieve using PHP's HTTP wrapper.

Last, pin!

    $p->pin($p->boards['My named board']);

And that's all there is to it.

Questions?  Email me:  steve@stevehavelka.com
