<?php

namespace HengeBytes\IbexaBlurhashBundle\FieldType\Image;

class ImageConverter extends \Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\ImageConverter
{
    /**
     * Same as core, but with fixed issue in additionalData tag containing %s
     */
    protected function fillXml($imageData, $pathInfo, $timestamp)
    {
        $placeholder = '_ADDITIONAL_DATA_PLACEHOLDER_';
        $additionalData = $this->buildAdditionalDataTag($imageData['additionalData'] ?? []);

        $xml = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<ezimage serial_number="1" is_valid="%s" filename="%s"
    suffix="%s" basename="%s" dirpath="%s" url="%s"
    original_filename="%s" mime_type="%s" width="%s"
    height="%s" alternative_text="%s" alias_key="%s" timestamp="%s">
  <original attribute_id="%s" attribute_version="%s" attribute_language="%s"/>
  <information Height="%s" Width="%s" IsColor="%s"/>
  $placeholder
</ezimage>
EOT;

        $xmlString =  sprintf(
            $xml,
            // <ezimage>
            ($pathInfo['basename'] !== '' ? '1' : ''), // is_valid="%s"
            htmlspecialchars($pathInfo['basename']), // filename="%s"
            htmlspecialchars($pathInfo['extension']), // suffix="%s"
            htmlspecialchars($pathInfo['filename']), // basename="%s"
            htmlspecialchars($pathInfo['dirname']), // dirpath
            htmlspecialchars($imageData['uri']), // url
            htmlspecialchars($pathInfo['basename']), // @todo: Needs original file name, for whatever reason?
            htmlspecialchars($imageData['mime']), // mime_type
            htmlspecialchars($imageData['width']), // width
            htmlspecialchars($imageData['height']), // height
            htmlspecialchars($imageData['alternativeText']), // alternative_text
            htmlspecialchars(1293033771), // alias_key, fixed for the original image
            htmlspecialchars($timestamp), // timestamp
            // <original>
            $imageData['fieldId'],
            $imageData['versionNo'],
            $imageData['languageCode'],
            // <information>
            $imageData['height'], // Height
            $imageData['width'], // Width
            1// IsColor @todo Do we need to fix that here?
        );

        return str_replace($placeholder, $additionalData, $xmlString);
    }

    /**
     * Same as core, but it's private in core
     */
    private function buildAdditionalDataTag(array $imageEditorData): string
    {
        $xml = new \SimpleXMLElement('<additional_data/>');
        foreach ($imageEditorData as $option => $value) {
            $xml->addChild('attribute', (string) $value)->addAttribute('key', $option);
        }

        // Cutout xml header
        $dom = dom_import_simplexml($xml);

        return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
    }
}