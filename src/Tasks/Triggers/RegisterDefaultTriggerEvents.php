<?php

namespace Mantiq\Tasks\Triggers;

use Mantiq\Triggers\Events\Attachments\AttachmentAdded;
use Mantiq\Triggers\Events\Attachments\AttachmentDeleted;
use Mantiq\Triggers\Events\Comments\CommentDeleted;
use Mantiq\Triggers\Events\Comments\CommentPosted;
use Mantiq\Triggers\Events\Comments\CommentSpam;
use Mantiq\Triggers\Events\Comments\CommentTrashed;
use Mantiq\Triggers\Events\Comments\CommentUpdated;
use Mantiq\Triggers\Events\Developers\PageFooter;
use Mantiq\Triggers\Events\Developers\PageHead;
use Mantiq\Triggers\Events\Developers\WordPressLoaded;
use Mantiq\Triggers\Events\Posts\PostDeleted;
use Mantiq\Triggers\Events\Posts\PostPending;
use Mantiq\Triggers\Events\Posts\PostPublished;
use Mantiq\Triggers\Events\Posts\PostTrashed;
use Mantiq\Triggers\Events\Posts\PostUpdated;
use Mantiq\Triggers\Events\Users\UserDeleted;
use Mantiq\Triggers\Events\Users\UserLoggedIn;
use Mantiq\Triggers\Events\Users\UserLoggedOut;
use Mantiq\Triggers\Events\Users\UserRegistered;

class RegisterDefaultTriggerEvents
{
    public static function invoke()
    {
        PostPublished::register();
        PostTrashed::register();
        PostPending::register();
        PostUpdated::register();
        PostDeleted::register();

        AttachmentDeleted::register();
        AttachmentAdded::register();

        CommentPosted::register();
        CommentUpdated::register();
        CommentSpam::register();
        CommentTrashed::register();
        CommentDeleted::register();

        UserDeleted::register();
        UserLoggedIn::register();
        UserLoggedOut::register();
        UserRegistered::register();

        WordPressLoaded::register();
        PageHead::register();
        PageFooter::register();
    }

}
