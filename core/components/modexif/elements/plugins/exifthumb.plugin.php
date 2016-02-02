<?php
use PHPExiftool\Driver\Value\Mono;
use PHPExiftool\Driver\Value\Binary;
use PHPExiftool\Driver\Value\Multi;
// IPTC (International Press Telecommunications Council) aka IIM
use PHPExiftool\Driver\Tag\IPTC\OwnerID;
use PHPExiftool\Driver\Tag\IPTC\ObjectName;
use PHPExiftool\Driver\Tag\IPTC\UniqueDocumentID;
use PHPExiftool\Driver\Tag\IPTC\LocalCaption;
use PHPExiftool\Driver\Tag\IPTC\Keywords;
// XMP (eXtensible Metadata Platform)
use PHPExiftool\Driver\Tag\XMPXmp\Label;
use PHPExiftool\Driver\Tag\XMPXmp\Nickname;
use PHPExiftool\Driver\Tag\XMPXmp\CreateDate;
// EXIF (Exchangeable Image File Format)
use PHPExiftool\Driver\Tag\ExifIFD\UserComment;

if ($modx->event->name == 'OnModExifMetaTagAdd') {
    $_translit = function ($text) use ($modx) {
        $modx->getService('translit', $modx->getOption('friendly_alias_translit_class'), $modx->getOption('friendly_alias_translit_class_path'));
        return $modx->translit->translate($text, $modx->getOption('friendly_alias_translit'));
    };

    // format: [{"name":"tagClass","value":"tagValue","type":"ex. mono"}]
    foreach ($tags as $tag) {
        switch ($tag['name']) {

            case 'OwnerID':
                $metadataBag->add($writer->tagGet(new OwnerID(), new Mono($tag['value'])));
                break;

            case 'UniqueDocumentID':
                $metadataBag->add($writer->tagGet(new UniqueDocumentID(), new Mono($tag['value'])));
                break;

            case 'LocalCaption':
                $metadataBag->add($writer->tagGet(new LocalCaption(), new Mono($_translit($tag['value']))));
                break;

            case 'Keywords':
                $metadataBag->add($writer->tagGet(new Keywords(), new Mono($_translit($tag['value']))));
                break;

            case 'UserComment':
                $metadataBag->add($writer->tagGet(new UserComment(), new Mono($_translit($tag['value']))));
                break;

            case 'ObjectName':
                $metadataBag->add($writer->tagGet(new ObjectName(), new Mono($tag['value'])));
                break;

            case 'Label':
                $metadataBag->add($writer->tagGet(new Label(), new Mono($_translit($tag['value']))));
                break;

            case 'Nickname':
                $metadataBag->add($writer->tagGet(new Nickname(), new Mono($_translit($tag['value']))));
                break;

            case 'CreateDate':
            default:
                $date = new DateTime();
                $metadataBag->add($writer->tagGet(new CreateDate(), new Binary($date->format('c'))));
                break;

        }
    }
}
