<?php

namespace Jamosaur\Avtr;

use Jamosaur\Avtr\Exceptions\InvalidFontException;
use Jamosaur\Avtr\Exceptions\InvalidFormatException;
use Jamosaur\Avtr\Exceptions\InvalidShapeException;
use Jamosaur\Avtr\Exceptions\InvalidTextCaseException;
use Jamosaur\Avtr\Exceptions\InvalidThemeException;

class AvtrTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructingWithEmail()
    {
        $avtr = new Avtr('email@test.com');
        $this->assertEquals(Avtr::URL . 'png?email=email%40test.com', $avtr->toUrl());
    }

    public function testConstructingWithInitials()
    {
        $avtr = new Avtr('JW');
        $this->assertEquals(Avtr::URL . 'png?initials=JW', $avtr->toUrl());
    }

    public function testConstructingWithFullName()
    {
        $avtr = new Avtr('James Wallen-Jones');
        $this->assertEquals(Avtr::URL . 'png?first_name=James&last_name=Wallen-Jones', $avtr->toUrl());
    }

    public function testConstructingWithFirstName()
    {
        $avtr = new Avtr('James');
        $this->assertEquals(Avtr::URL . 'png?initials=James', $avtr->toUrl());
    }

    public function testConstructingWithNothing()
    {
        $avtr = new Avtr;
        $this->assertEquals(Avtr::URL . 'png', $avtr->toUrl());
    }

    public function testSettingFormat()
    {
        $avtr = new Avtr;
        $this->assertEquals(Avtr::URL . 'png', $avtr->toUrl());
        $avtr->format('jpg');
        $this->assertEquals(Avtr::URL . 'jpg', $avtr->toUrl());
        $avtr->format('gif');
        $this->assertEquals(Avtr::URL . 'gif', $avtr->toUrl());
    }

    public function testSettingInvalidFormatThrowsException()
    {
        $this->expectException(InvalidFormatException::class);
        (new Avtr)->format('webm');
    }

    public function testSettingFirstName()
    {
        $avtr = (new Avtr)->firstName('James');
        $this->assertEquals(Avtr::URL . 'png?first_name=James', $avtr->toUrl());
    }

    public function testSettingLastName()
    {
        $avtr = (new Avtr)->lastName('Wallen-Jones');
        $this->assertEquals(Avtr::URL . 'png?last_name=Wallen-Jones', $avtr->toUrl());
    }

    public function testSettingLetterCount()
    {
        $avtr = (new Avtr)->letterCount(1);
        $this->assertEquals(Avtr::URL . 'png?letter_count=1', $avtr->toUrl());
        $avtr->letterCount(2);
        $this->assertEquals(Avtr::URL . 'png?letter_count=2', $avtr->toUrl());
        $avtr->letterCount(420);
        $this->assertEquals(Avtr::URL . 'png?letter_count=2', $avtr->toUrl());
        $avtr->letterCount(-69);
        $this->assertEquals(Avtr::URL . 'png?letter_count=2', $avtr->toUrl());
    }

    public function testSettingBackground()
    {
        $avtr = (new Avtr)->background(100, 100, 100, 0.5);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%28100%2C100%2C100%2C0.5%29', $avtr->toUrl());
        $avtr->background(255, 255, 255);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%28255%2C255%2C255%2C1%29', $avtr->toUrl());
        $avtr->background(1000, 1987234, 23846782364);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%28255%2C255%2C255%2C1%29', $avtr->toUrl());
        $avtr->background(-1000, -1987234, -23846782364);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%280%2C0%2C0%2C1%29', $avtr->toUrl());
        $avtr->background(-1000, -1987234, -23846782364, -12);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%280%2C0%2C0%2C0%29', $avtr->toUrl());
        $avtr->background(-1000, -1987234, -23846782364, 12);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%280%2C0%2C0%2C1%29', $avtr->toUrl());
        $avtr->background(-1000, -1987234, -23846782364, 0.5);
        $this->assertEquals(Avtr::URL . 'png?background=rgba%280%2C0%2C0%2C0.5%29', $avtr->toUrl());
    }

    public function testSettingSize()
    {
        $avtr = (new Avtr)->size(500);
        $this->assertEquals(Avtr::URL . 'png?size=500', $avtr->toUrl());
        $avtr->size(-100);
        $this->assertEquals(Avtr::URL . 'png?size=100', $avtr->toUrl());
    }

    public function testSettingRoundedCorners()
    {
        $avtr = (new Avtr)->roundedCorners(true);
        $this->assertEquals(Avtr::URL . 'png?rounded_corners=1', $avtr->toUrl());
        $avtr->roundedCorners(false);
        $this->assertEquals(Avtr::URL . 'png', $avtr->toUrl());
    }

    public function testSettingShapes()
    {
        $avtr = (new Avtr)->shape('square');
        $this->assertEquals(Avtr::URL . 'png?shape=square', $avtr->toUrl());
        $avtr->shape('circle');
        $this->assertEquals(Avtr::URL . 'png?shape=circle', $avtr->toUrl());
        $this->expectException(InvalidShapeException::class);
        $avtr->shape('triangle');
    }

    public function testSettingTheme()
    {
        $avtr = (new Avtr)->theme('material');
        $this->assertEquals(Avtr::URL . 'png?theme=material', $avtr->toUrl());
        $avtr->theme('flat');
        $this->assertEquals(Avtr::URL . 'png?theme=flat', $avtr->toUrl());
        $this->expectException(InvalidThemeException::class);
        $avtr->theme('metro');
    }

    public function testSettingFontCase()
    {
        $avtr = (new Avtr)->textCase('lower');
        $this->assertEquals(Avtr::URL . 'png?text_case=lower', $avtr->toUrl());
        $avtr->textCase('upper');
        $this->assertEquals(Avtr::URL . 'png?text_case=upper', $avtr->toUrl());
        $avtr->textCase('title');
        $this->assertEquals(Avtr::URL . 'png?text_case=title', $avtr->toUrl());
        $this->expectException(InvalidTextCaseException::class);
        $avtr->textCase('camel');
    }

    public function testSettingTextColor()
    {
        $avtr = (new Avtr)->color(100, 100, 100, 0.5);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%28100%2C100%2C100%2C0.5%29', $avtr->toUrl());
        $avtr->color(255, 255, 255);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%28255%2C255%2C255%2C1%29', $avtr->toUrl());
        $avtr->color(1000, 1987234, 23846782364);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%28255%2C255%2C255%2C1%29', $avtr->toUrl());
        $avtr->color(-1000, -1987234, -23846782364);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%280%2C0%2C0%2C1%29', $avtr->toUrl());
        $avtr->color(-1000, -1987234, -23846782364, -12);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%280%2C0%2C0%2C0%29', $avtr->toUrl());
        $avtr->color(-1000, -1987234, -23846782364, 12);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%280%2C0%2C0%2C1%29', $avtr->toUrl());
        $avtr->color(-1000, -1987234, -23846782364, 0.5);
        $this->assertEquals(Avtr::URL . 'png?text_color=rgba%280%2C0%2C0%2C0.5%29', $avtr->toUrl());
    }

    public function testSettingFontWeight()
    {
        $avtr = (new Avtr)->fontWeight(100);
        $this->assertEquals(Avtr::URL . 'png?font_weight=100', $avtr->toUrl());
        $avtr->fontWeight(200);
        $this->assertEquals(Avtr::URL . 'png?font_weight=200', $avtr->toUrl());
        $avtr->fontWeight(300);
        $this->assertEquals(Avtr::URL . 'png?font_weight=300', $avtr->toUrl());
        $avtr->fontWeight(400);
        $this->assertEquals(Avtr::URL . 'png?font_weight=400', $avtr->toUrl());
        $avtr->fontWeight(500);
        $this->assertEquals(Avtr::URL . 'png?font_weight=500', $avtr->toUrl());
        $avtr->fontWeight(600);
        $this->assertEquals(Avtr::URL . 'png?font_weight=600', $avtr->toUrl());
        $avtr->fontWeight(700);
        $this->assertEquals(Avtr::URL . 'png?font_weight=700', $avtr->toUrl());
        $avtr->fontWeight(800);
        $this->assertEquals(Avtr::URL . 'png?font_weight=800', $avtr->toUrl());
        $avtr->fontWeight(900);
        $this->assertEquals(Avtr::URL . 'png?font_weight=900', $avtr->toUrl());
        $avtr->fontWeight(10000000);
        $this->assertEquals(Avtr::URL . 'png?font_weight=900', $avtr->toUrl());
        $avtr->fontWeight(-10000000);
        $this->assertEquals(Avtr::URL . 'png?font_weight=100', $avtr->toUrl());
    }

    public function testSettingFont()
    {
        $avtr = (new Avtr)->font('open-sans');
        $this->assertEquals(Avtr::URL . 'png?font=open-sans', $avtr->toUrl());
        $avtr->font('source-sans-pro');
        $this->assertEquals(Avtr::URL . 'png?font=source-sans-pro', $avtr->toUrl());
        $avtr->font('roboto');
        $this->assertEquals(Avtr::URL . 'png?font=roboto', $avtr->toUrl());
        $this->expectException(InvalidFontException::class);
        $avtr->font('invalid font');
    }

    public function testAll()
    {
        $avtr = (new Avtr('Jamosaur'))->font('open-sans')
            ->fontWeight(100)
            ->textCase('lower')
            ->theme('flat')
            ->shape('square')
            ->roundedCorners(1)
            ->size(500)
            ->format('jpg')
            ->background(0, 0, 0, 1)
            ->color(255, 69, 0, 1);

        $this->assertEquals(Avtr::URL . 'jpg?initials=Jamosaur&background=rgba%280%2C0%2C0%2C1%29&size=500' .
            '&rounded_corners=1&shape=square&theme=flat&text_case=lower&text_color=rgba%28255%2C69%2C0%2C1%29'.
        '&font_weight=100&font=open-sans', $avtr->toUrl());
    }
}
