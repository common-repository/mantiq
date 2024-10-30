<?php

namespace Mantiq\Support;

use Mantiq\Models\DataType;

class CommonDataTypes
{
    public static function WP_Post()
    {
        return DataType::object(
            [
                [
                    'id'   => 'ID',
                    'name' => 'Post ID',
                    'type' => DataType::integer(),
                ],

                [
                    'id'   => 'post_title',
                    'name' => 'Post title',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_content',
                    'name' => 'Post content',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_excerpt',
                    'name' => 'Post excerpt',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_name',
                    'name' => 'Post slug',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_author',
                    'name' => 'Post author ID',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_date',
                    'name' => 'Post date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_date_gmt',
                    'name' => 'Post date (GMT)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_modified',
                    'name' => 'Post last update date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_modified_gmt',
                    'name' => 'Post last update date (GMT)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_parent',
                    'name' => 'Post parent ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'post_status',
                    'name' => 'Post status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_status',
                    'name' => 'Comments status',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'post_type',
                    'name' => 'Post type',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_count',
                    'name' => 'Comments count',
                    'type' => DataType::string(),
                ],
            ]
        );
    }

    public static function WP_Comment()
    {
        return DataType::object(
            [
                [
                    'id'   => 'comment_ID',
                    'name' => 'Comment ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_post_ID',
                    'name' => 'Comment post ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_parent',
                    'name' => 'Comment parent ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'user_id',
                    'name' => 'Comment author user ID',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_content',
                    'name' => 'Comment content',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author',
                    'name' => 'Comment author name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_email',
                    'name' => 'Comment author email',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_url',
                    'name' => 'Comment author URL',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_author_IP',
                    'name' => 'Comment author IP',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_date',
                    'name' => 'Comment date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_date_gmt',
                    'name' => 'Comment date (GMT)',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'comment_approved',
                    'name' => 'Comment approval status',
                    'type' => DataType::integer(),
                ],
                [
                    'id'   => 'comment_type',
                    'name' => 'Comment type',
                    'type' => DataType::string(),
                ],
            ]
        );
    }

    public static function WP_User()
    {
        return DataType::object(
            [
                [
                    'id'   => 'ID',
                    'name' => 'User ID',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'roles',
                    'name' => 'User roles',
                    'type' => DataType::array(),
                ],
                [
                    'id'   => 'user_firstname',
                    'name' => 'User first name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_lastname',
                    'name' => 'User last name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_description',
                    'name' => 'User description',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_login',
                    'name' => 'Username',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'display_name',
                    'name' => 'User display name',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_email',
                    'name' => 'User email',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_url',
                    'name' => 'User URL',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_status',
                    'name' => 'User status',
                    'type' => DataType::integer(),
                ],
            ]
        );
    }

    public static function WP_Term()
    {
        return DataType::object(
            [
                [
                    'id'   => 'user_title',
                    'name' => 'User title',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_date',
                    'name' => 'User date',
                    'type' => DataType::string(),
                ],
                [
                    'id'   => 'user_slug',
                    'name' => 'User slug',
                    'type' => DataType::string(),
                ],
            ]
        );
    }
}
