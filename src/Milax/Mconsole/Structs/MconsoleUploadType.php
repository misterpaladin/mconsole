<?php

namespace Milax\Mconsole\Structs;

/**
 * Enum for Upload class
 */
abstract class MconsoleUploadType
{
    const Image = 'image';
    const Document = 'document';
    const Audio = 'audio';
    const Video = 'video';
}