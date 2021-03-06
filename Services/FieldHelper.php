<?php

namespace SQLI\CommandsToolboxBundle\Services;

use eZ\Publish\API\Repository\Values\Content\Content;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\Core\Helper\FieldHelper as EzFieldHelper;
use eZ\Publish\Core\Helper\TranslationHelper;

class FieldHelper
{
    /** @var EzFieldHelper */
    private $fieldHelper;
    /** @var TranslationHelper */
    private $translationHelper;

    public function __construct( EzFieldHelper $fieldHelper, TranslationHelper $translationHelper )
    {
        $this->fieldHelper       = $fieldHelper;
        $this->translationHelper = $translationHelper;
    }

    /**
     * @param Content      $content
     * @param Field|string $fieldDefIdentifier Field or Field Identifier to get the value from.
     * @param string       $forcedLanguage Locale we want the content name translation in (e.g. "fre-FR").
     *                                     Null by default (takes current locale).
     *
     * @return bool
     * @see \eZ\Publish\Core\Helper\FieldHelper
     *
     * Checks if a given field is considered empty.
     * This method accepts field as Objects or by identifiers.
     *
     */
    public function isEmptyField( Content $content, $fieldDefIdentifier, $forcedLanguage = null )
    {
        if( $fieldDefIdentifier instanceof Field )
        {
            $fieldDefIdentifier = $fieldDefIdentifier->fieldDefIdentifier;
        }

        // Check if field exist in content type definition
        if( $content->getContentType()->getFieldDefinition( $fieldDefIdentifier ) === null )
        {
            return true;
        }

        // Field exists, check if value is empty
        return $this->fieldHelper->isFieldEmpty( $content, $fieldDefIdentifier, $forcedLanguage );
    }
}