<?php

namespace Milax\Mconsole\Structs;

/**
 * Enum for Upload class
 */
abstract class MconsoleUploadType
{
    const Any = 'any';
    const Image = 'image';
    const Document = 'document';
    const Audio = 'audio';
    const Video = 'video';
}