<?php

return [
    'encoding'           => 'UTF-8',
    'finalize'           => true,
    'ignoreNonStrings'   => false,
    'cachePath'          => storage_path('app/purifier'),
    'cacheFileMode'      => 0755,
    'settings'      => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'div,b,strong,i,em,u,a[href|title|data-trix-attachment|data-trix-content-type|data-trix-attributes|class],ul,ol,li,p[style],br,span[style|class],img[width|height|alt|src],h1,h2,h3,h4,h5,h6,figure[data-trix-attachment|data-trix-content-type|data-trix-attributes|class],figcaption[class],blockquote,pre,code,hr',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false,
            'Attr.EnableID'            => true,
            'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            'HTML.SafeIframe'          => true,
            'URI.SafeIframeRegexp'     => '%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%',
            'HTML.TidyLevel'           => 'none', // Jangan ubah struktur HTML
            'HTML.Nofollow'            => false,
            'Cache.SerializerPath'     => storage_path('app/purifier'),
            'HTML.TargetNoopener'      => true,
            'HTML.TargetNoreferrer'    => true,
            'HTML.ForbiddenElements'   => ['script', 'applet', 'iframe', 'form', 'input', 'button', 'select', 'textarea', 'style'],
            'Attr.AllowedRel'          => ['nofollow', 'noopener', 'noreferrer'],
            'HTML.MaxImgLength'        => null, // Tidak ada batasan untuk dimensi gambar
            'CSS.MaxImgLength'         => null, // Tidak ada batasan untuk dimensi gambar di CSS
            'URI.MakeAbsolute'         => false, // Jangan ubah URL relatif menjadi absolut
            'URI.DisableExternalResources' => false, // Izinkan sumber daya eksternal
            'URI.DisableResources'     => false, // Izinkan sumber daya
        ],
        'trix_editor' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'div[*],b,strong,i,em,u,a[href|title|data-trix-attachment|data-trix-content-type|data-trix-attributes|class|*],ul,ol,li,p[style|*],br,span[style|class|*],img[width|height|alt|src|*],h1,h2,h3,h4,h5,h6,figure[data-trix-attachment|data-trix-content-type|data-trix-attributes|class|*],figcaption[class|*],blockquote,pre,code,hr',
            'CSS.AllowedProperties'    => '*',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false,
            'AutoFormat.Linkify'       => false,
            'Attr.EnableID'            => true,
            'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            'HTML.SafeIframe'          => true,
            'URI.SafeIframeRegexp'     => '%^(http://|https://|//)(www.youtube.com/embed/|player.vimeo.com/video/)%',
            'HTML.TidyLevel'           => 'none',
            'HTML.Nofollow'            => false,
            'Cache.SerializerPath'     => storage_path('app/purifier'),
            'HTML.TargetNoopener'      => true,
            'HTML.TargetNoreferrer'    => true,
            'HTML.ForbiddenElements'   => ['script', 'applet', 'iframe', 'form', 'input', 'button', 'select', 'textarea', 'style'],
            'Attr.AllowedRel'          => ['nofollow', 'noopener', 'noreferrer'],
            'HTML.MaxImgLength'        => null,
            'CSS.MaxImgLength'         => null,
            'URI.MakeAbsolute'         => false,
            'URI.DisableExternalResources' => false,
            'URI.DisableResources'     => false,
        ],
        'custom_definition' => [
            'id'  => 'html5-definitions',
            'rev' => 1,
            'debug' => false,
            'elements' => [
                // http://developers.whatwg.org/sections.html
                ['section', 'Block', 'Flow', 'Common'],
                ['nav',     'Block', 'Flow', 'Common'],
                ['article', 'Block', 'Flow', 'Common'],
                ['aside',   'Block', 'Flow', 'Common'],
                ['header',  'Block', 'Flow', 'Common'],
                ['footer',  'Block', 'Flow', 'Common'],
                
                // Content model actually excludes several tags, not modelled here
                ['address', 'Block', 'Flow', 'Common'],
                ['hgroup', 'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common'],
                
                // http://developers.whatwg.org/grouping-content.html
                ['figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common'],
                ['figcaption', 'Inline', 'Flow', 'Common'],
                
                // http://developers.whatwg.org/the-video-element.html#the-video-element
                ['video', 'Block', 'Optional: (source, Flow) | (Flow, source) | Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                    'width' => 'Length',
                    'height' => 'Length',
                    'poster' => 'URI',
                    'preload' => 'Enum#auto,metadata,none',
                    'controls' => 'Bool',
                ]],
                ['source', 'Block', 'Flow', 'Common', [
                    'src' => 'URI',
                    'type' => 'Text',
                ]],

                // http://developers.whatwg.org/text-level-semantics.html
                ['s',    'Inline', 'Inline', 'Common'],
                ['var',  'Inline', 'Inline', 'Common'],
                ['sub',  'Inline', 'Inline', 'Common'],
                ['sup',  'Inline', 'Inline', 'Common'],
                ['mark', 'Inline', 'Inline', 'Common'],
                ['wbr',  'Inline', 'Empty', 'Core'],
                
                // http://developers.whatwg.org/edits.html
                ['ins', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
                ['del', 'Block', 'Flow', 'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
            ],
            'attributes' => [
                ['iframe', 'allowfullscreen', 'Bool'],
                ['table', 'height', 'Text'],
                ['td', 'border', 'Text'],
                ['th', 'border', 'Text'],
                ['tr', 'width', 'Text'],
                ['tr', 'height', 'Text'],
                ['tr', 'border', 'Text'],
                ['a', 'data-trix-attachment', 'Text'],
                ['a', 'data-trix-content-type', 'Text'],
                ['a', 'data-trix-attributes', 'Text'],
                ['figure', 'data-trix-attachment', 'Text'],
                ['figure', 'data-trix-content-type', 'Text'],
                ['figure', 'data-trix-attributes', 'Text'],
            ],
        ],
        'custom_attributes' => [
            ['a', 'target', 'Enum#_blank,_self,_target,_top'],
            ['a', 'data-trix-attachment', 'Text'],
            ['a', 'data-trix-content-type', 'Text'],
            ['a', 'data-trix-attributes', 'Text'],
            ['figure', 'data-trix-attachment', 'Text'],
            ['figure', 'data-trix-content-type', 'Text'],
            ['figure', 'data-trix-attributes', 'Text'],
        ],
        'custom_elements' => [
            ['u', 'Inline', 'Inline', 'Common'],
            ['figure', 'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common'],
            ['figcaption', 'Inline', 'Flow', 'Common'],
        ],
    ],
];