<?php

namespace Mantiq\Tasks\Actions;

use Mantiq\Actions\Comments\CreateComment;
use Mantiq\Actions\Comments\DeleteComment;
use Mantiq\Actions\Comments\GetComment;
use Mantiq\Actions\Comments\QueryComments;
use Mantiq\Actions\Comments\TrashComment;
use Mantiq\Actions\Comments\UpdateComment;
use Mantiq\Actions\Developers\EchoOutput;
use Mantiq\Actions\Developers\EncodeAsJSON;
use Mantiq\Actions\Developers\ExecuteHTTPRequest;
use Mantiq\Actions\Developers\WriteToLog;
use Mantiq\Actions\Metadata\CreateMetadata;
use Mantiq\Actions\Metadata\DeleteMetadata;
use Mantiq\Actions\Metadata\GetMetadata;
use Mantiq\Actions\Metadata\UpdateMetadata;
use Mantiq\Actions\Options\CreateOption;
use Mantiq\Actions\Options\DeleteOption;
use Mantiq\Actions\Options\GetOption;
use Mantiq\Actions\Options\UpdateOption;
use Mantiq\Actions\Posts\CreatePost;
use Mantiq\Actions\Posts\DeletePost;
use Mantiq\Actions\Posts\GetPost;
use Mantiq\Actions\Posts\QueryPosts;
use Mantiq\Actions\Posts\TrashPost;
use Mantiq\Actions\Posts\UpdatePost;
use Mantiq\Actions\SendEmail;
use Mantiq\Actions\Terms\AssignTermsToPost;
use Mantiq\Actions\Terms\CreateTerm;
use Mantiq\Actions\Terms\DeleteTerm;
use Mantiq\Actions\Terms\GetTerm;
use Mantiq\Actions\Terms\QueryTerms;
use Mantiq\Actions\Terms\TrashTerm;
use Mantiq\Actions\Terms\UpdateTerm;
use Mantiq\Actions\Users\CreateUser;
use Mantiq\Actions\Users\DeleteUser;
use Mantiq\Actions\Users\GetUser;
use Mantiq\Actions\Users\QueryUsers;
use Mantiq\Actions\Users\UpdateUser;

class RegisterDefaultActions
{
    public static function invoke()
    {
        SendEmail::register();

        // Posts
        CreatePost::register();
        UpdatePost::register();
        DeletePost::register();
        TrashPost::register();
        GetPost::register();
        QueryPosts::register();

        // Comments
        CreateComment::register();
        UpdateComment::register();
        DeleteComment::register();
        TrashComment::register();
        GetComment::register();
        QueryComments::register();

        // Users
        CreateUser::register();
        UpdateUser::register();
        DeleteUser::register();
        GetUser::register();
        QueryUsers::register();

        // Terms
        CreateTerm::register();
        UpdateTerm::register();
        DeleteTerm::register();
        GetTerm::register();
        QueryTerms::register();
        AssignTermsToPost::register();

        // Metadata
        CreateMetadata::register();
        UpdateMetadata::register();
        DeleteMetadata::register();
        GetMetadata::register();

        // Options
        CreateOption::register();
        UpdateOption::register();
        DeleteOption::register();
        GetOption::register();

        // Developers
        EchoOutput::register();
        EncodeAsJSON::register();
        WriteToLog::register();
        ExecuteHTTPRequest::register();
    }
}
