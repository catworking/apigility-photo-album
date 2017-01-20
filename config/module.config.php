<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilityPhotoAlbum\V1\Rest\Album\AlbumResource::class => \ApigilityPhotoAlbum\V1\Rest\Album\AlbumResourceFactory::class,
            \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoResource::class => \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-photo-album.rest.album' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/photo-album/album[/:album_id]',
                    'defaults' => [
                        'controller' => 'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller',
                    ],
                ],
            ],
            'apigility-photo-album.rest.photo' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/photo-album/photo[/:photo_id]',
                    'defaults' => [
                        'controller' => 'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-photo-album.rest.album',
            1 => 'apigility-photo-album.rest.photo',
        ],
    ],
    'zf-rest' => [
        'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => [
            'listener' => \ApigilityPhotoAlbum\V1\Rest\Album\AlbumResource::class,
            'route_name' => 'apigility-photo-album.rest.album',
            'route_identifier_name' => 'album_id',
            'collection_name' => 'album',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'DELETE',
                2 => 'PATCH',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityPhotoAlbum\V1\Rest\Album\AlbumEntity::class,
            'collection_class' => \ApigilityPhotoAlbum\V1\Rest\Album\AlbumCollection::class,
            'service_name' => 'Album',
        ],
        'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => [
            'listener' => \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoResource::class,
            'route_name' => 'apigility-photo-album.rest.photo',
            'route_identifier_name' => 'photo_id',
            'collection_name' => 'photo',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
                2 => 'DELETE',
            ],
            'collection_query_whitelist' => [
                0 => 'album_id',
                1 => 'user_id',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoEntity::class,
            'collection_class' => \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoCollection::class,
            'service_name' => 'Photo',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => 'HalJson',
            'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => [
                0 => 'application/vnd.apigility-photo-album.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => [
                0 => 'application/vnd.apigility-photo-album.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => [
                0 => 'application/vnd.apigility-photo-album.v1+json',
                1 => 'application/json',
            ],
            'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => [
                0 => 'application/vnd.apigility-photo-album.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilityPhotoAlbum\V1\Rest\Album\AlbumEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-photo-album.rest.album',
                'route_identifier_name' => 'album_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityPhotoAlbum\V1\Rest\Album\AlbumCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-photo-album.rest.album',
                'route_identifier_name' => 'album_id',
                'is_collection' => true,
            ],
            \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-photo-album.rest.photo',
                'route_identifier_name' => 'photo_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilityPhotoAlbum\V1\Rest\Photo\PhotoCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-photo-album.rest.photo',
                'route_identifier_name' => 'photo_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
            'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'zf-content-validation' => [
        'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Controller' => [
            'input_filter' => 'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Validator',
        ],
        'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Controller' => [
            'input_filter' => 'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'ApigilityPhotoAlbum\\V1\\Rest\\Album\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
                'description' => '标识',
                'continue_if_empty' => true,
                'allow_empty' => true,
                'field_type' => 'int',
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'name',
                'description' => '相册名称',
                'error_message' => '请输入相册名称',
                'field_type' => 'string',
            ],
        ],
        'ApigilityPhotoAlbum\\V1\\Rest\\Photo\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
                'description' => '标识',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'field_type' => 'int',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'title',
                'description' => '标题',
                'field_type' => 'string',
                'allow_empty' => true,
                'continue_if_empty' => true,
                'error_message' => '请输入标题',
            ],
            2 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'uri',
                'description' => '照片地址',
                'error_message' => '请输入照片地址',
                'field_type' => 'string',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'album_id',
                'description' => '相册',
                'error_message' => '请指定照片的相册',
                'field_type' => 'int',
                'allow_empty' => true,
                'continue_if_empty' => true,
            ],
        ],
    ],
];
