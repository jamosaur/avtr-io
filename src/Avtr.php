<?php declare(strict_types=1);

namespace Jamosaur\Avtr;

use Jamosaur\Avtr\Exceptions\InvalidFontException;
use Jamosaur\Avtr\Exceptions\InvalidFormatException;
use Jamosaur\Avtr\Exceptions\InvalidShapeException;
use Jamosaur\Avtr\Exceptions\InvalidTextCaseException;
use Jamosaur\Avtr\Exceptions\InvalidThemeException;

/**
 * Class Avtr
 *
 * @package Jamosaur\Avtr
 * @author  James Wallen-Jones <j.wallen.jones@googlemail.com>
 */
class Avtr
{
    /**
     * URL For the API.
     */
    const URL = 'https://avtr.io/avtr.';

    /**
     * Config parameters.
     *
     * @var array
     */
    protected $config = [
        'initials'        => null,
        'first_name'      => null,
        'last_name'       => null,
        'email'           => null,
        'letter_count'    => null,
        'background'      => null,
        'size'            => null,
        'rounded_corners' => null,
        'shape'           => null,
        'theme'           => null,
        'text_case'       => null,
        'text_color'      => null,
        'font_weight'     => null,
        'font'            => null,
    ];

    /**
     * Default Format that should be returned.
     *
     * @var string
     */
    protected $format = 'png';

    /**
     * Avtr constructor.
     *
     * @param string $value
     */
    public function __construct(string $value = '')
    {
        if (strpos($value, '@')) {
            $this->config['email'] = $value;
        } elseif (str_word_count($value) > 1) {
            $this->config['first_name'] = explode(' ', $value)[0];
            $this->config['last_name']  = explode(' ', $value)[1];
        } else {
            $this->config['initials'] = (($value === '') ? null : $value);
        }
    }

    /**
     * Returns the URL.
     *
     * @return String
     */
    public function toUrl(): String
    {
        $values = count(array_filter($this->config));

        return self::URL . $this->format . (($values > 0) ? '?' . http_build_query($this->config) : null);
    }

    /**
     * Sets the format that should be returned.
     *
     * @param string $format
     *
     * @return Avtr
     * @throws InvalidFormatException
     */
    public function format(string $format): Avtr
    {
        $validFormats = ['png', 'jpg', 'gif'];
        if (!in_array($format, $validFormats)) {
            throw new InvalidFormatException;
        }
        $this->format = $format;

        return $this;
    }

    /**
     * Sets the first name.
     *
     * @param string $firstName
     *
     * @return Avtr
     */
    public function firstName(string $firstName): Avtr
    {
        $this->config['first_name'] = $firstName;

        return $this;
    }

    /**
     * Sets the last name.
     *
     * @param string $lastName
     *
     * @return Avtr
     */
    public function lastName(string $lastName): Avtr
    {
        $this->config['last_name'] = $lastName;

        return $this;
    }

    /**
     * Sets the letter count.
     *
     * @param int $count
     *
     * @return Avtr
     */
    public function letterCount(int $count): Avtr
    {
        if ($count < 1 || $count > 2) {
            $count = 2;
        }
        $this->config['letter_count'] = $count;

        return $this;
    }

    /**
     * Sets the background colour.
     *
     * @param int   $r
     * @param int   $g
     * @param int   $b
     * @param float $a
     *
     * @return Avtr
     */
    public function background(int $r, int $g, int $b, float $a = 1): Avtr
    {
        $this->setColour('background', $r, $g, $b, $a);

        return $this;
    }

    /**
     * Sets the image size.
     *
     * @param int $size
     *
     * @return Avtr
     */
    public function size(int $size): Avtr
    {
        if ($size < 0) {
            $size = 100;
        }

        $this->config['size'] = $size;

        return $this;
    }

    /**
     * Sets whether or not the square image should have rounded corners.
     *
     * @param bool $roundedCorners
     *
     * @return Avtr
     */
    public function roundedCorners(bool $roundedCorners): Avtr
    {
        $this->config['rounded_corners'] = (int)$roundedCorners;

        return $this;
    }

    /**
     * Sets the image shape.
     *
     * @param string $shape
     *
     * @return Avtr
     * @throws InvalidShapeException
     */
    public function shape(string $shape): Avtr
    {
        if (!in_array($shape, ['square', 'circle'])) {
            throw new InvalidShapeException;
        }

        $this->config['shape'] = $shape;

        return $this;
    }

    /**
     * Sets the theme.
     *
     * @param string $theme
     *
     * @return Avtr
     * @throws InvalidThemeException
     */
    public function theme(string $theme): Avtr
    {
        if (!in_array($theme, ['material', 'flat'])) {
            throw new InvalidThemeException;
        }

        $this->config['theme'] = $theme;

        return $this;
    }

    /**
     * Sets the text case.
     *
     * @param string $textCase
     *
     * @return Avtr
     * @throws InvalidTextCaseException
     */
    public function textCase(string $textCase): Avtr
    {
        if (!in_array($textCase, ['lower', 'upper', 'title'])) {
            throw new InvalidTextCaseException;
        }

        $this->config['text_case'] = $textCase;

        return $this;
    }

    /**
     * Sets the text colour.
     *
     * @param int   $r
     * @param int   $g
     * @param int   $b
     * @param float $a
     *
     * @return Avtr
     */
    public function color(int $r, int $g, int $b, float $a = 1): Avtr
    {
        $this->setColour('text_color', $r, $g, $b, $a);

        return $this;
    }

    /**
     * Sets the font weight.
     *
     * @param int $fontWeight
     *
     * @return Avtr
     */
    public function fontWeight(int $fontWeight): Avtr
    {
        $fontWeight                  = min(max($fontWeight, 100), 900);
        $this->config['font_weight'] = $fontWeight;

        return $this;
    }

    /**
     * Sets the font.
     *
     * @param string $font
     *
     * @return Avtr
     * @throws InvalidFontException
     */
    public function font(string $font): Avtr
    {
        $fonts = ['open-sans', 'source-sans-pro', 'roboto'];

        if (!in_array($font, $fonts)) {
            throw new InvalidFontException;
        }

        $this->config['font'] = $font;

        return $this;
    }

    /**
     * Validates and sets the appropriate config value for colours.
     *
     * @param string $where
     * @param int    $r
     * @param int    $g
     * @param int    $b
     * @param float  $a
     */
    private function setColour(string $where, int $r, int $g, int $b, float $a = 1)
    {
        $r = min(max($r, 0), 255);
        $g = min(max($g, 0), 255);
        $b = min(max($b, 0), 255);
        $a = min(max($a, 0), 1);

        $this->config[$where] = 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $a . ')';
    }
}
