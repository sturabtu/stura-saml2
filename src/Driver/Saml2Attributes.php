<?php

namespace StuRaBtu\Saml2\Driver;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use LightSaml\Model\Assertion\Attribute;

class Saml2Attributes
{
    /**
     * The SAML2 user attributes.
     *
     * @param  array<\Lightsaml\Model\Assertion\Attribute>  $attributes
     */
    public function __construct(
        protected array $attributes
    ) {}

    /**
     * Map the SAML2 user attributes to the Application User attributes
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return [
            'btu_id' => $this->asString('samlSubjectID'),
            'name' => $this->asString('cn'),
            'email' => $this->asString('mail'),
            'permissions' => $this->asArray('permissions'),
        ];
    }

    /**
     * Find the SAML2 user attribute by its friendly name.
     */
    public function find(string $friendlyName): ?Attribute
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getFriendlyName() === $friendlyName) {
                return $attribute;
            }
        }

        return null;
    }

    /**
     * Transform a SAML2 user attribute to an array.
     *
     * @return null|array<string>
     */
    public function asArray(string $friendlyName): ?array
    {
        $attribute = static::find($friendlyName);

        if ($attribute === null) {
            return [];
        }

        return $attribute->getAllAttributeValues();
    }

    /**
     * Transform a SAML2 user attribute to a string.
     */
    public function asString(string $friendlyName): ?string
    {
        $attribute = static::find($friendlyName);

        if ($attribute === null) {
            return null;
        }

        return $attribute->getFirstAttributeValue();
    }

    /**
     * Transform a SAML2 user attribute to a date.
     */
    public function asDate(string $friendlyName): ?Carbon
    {
        $attribute = static::find($friendlyName);

        if ($attribute === null) {
            return null;
        }

        return Carbon::createFromFormat('Ymd', $attribute->getFirstAttributeValue());
    }
}
