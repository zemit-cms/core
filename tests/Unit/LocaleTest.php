<?php
/**
 * This file is part of the Zemit Framework.
 *
 * (c) Zemit Team <contact@zemit.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Zemit\Tests\Unit;

use Zemit\Locale;

class LocaleTest extends AbstractUnit
{
    private ?Locale $locale;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->locale = $this->di->get('locale');
    }
    
    public function testLocaleInstanceFromDi(): void
    {
        $this->assertInstanceOf(Locale::class, $this->locale);
    }
    
    public function testInitializesCorrectly(): void
    {
        $this->locale->initialize();
        $this->assertEquals('zemit-locale', $this->locale->sessionKey);
        $this->assertEquals(['en'], $this->locale->allowed);
        $this->assertEquals('en', $this->locale->default);
        $this->assertEquals(Locale::MODE_DEFAULT, $this->locale->mode);
    }
    
    public function testInitializeOverridesDefaultsWithProvidedOptions(): void
    {
        $options = [
            'sessionKey' => 'custom-session-key',
            'allowed' => ['en', 'fr'],
            'default' => 'fr',
            'mode' => Locale::MODE_ROUTE
        ];
        $this->locale->setOptions($options);
        $this->locale->initialize();
        $this->assertEquals($options['sessionKey'], $this->locale->sessionKey);
        $this->assertEquals($options['allowed'], $this->locale->allowed);
        $this->assertEquals($options['default'], $this->locale->default);
        $this->assertEquals($options['mode'], $this->locale->mode);
        $this->assertEquals('fr', $this->locale->locale);
    }
    
    public function testModeGetSet(): void
    {
        $modes = [
            Locale::MODE_DEFAULT,
            Locale::MODE_SESSION,
            Locale::MODE_ROUTE,
            Locale::MODE_HTTP,
            'custom-mode',
        ];
        foreach ($modes as $mode) {
            $this->locale->setMode($mode);
            $this->assertEquals($mode, $this->locale->getMode());
        }
    }
    
    public function testDefaultGetSet(): void
    {
        $this->locale->setDefault('fr');
        $this->assertEquals('fr', $this->locale->getDefault());
    }
    
    public function testLocaleGetSet(): void
    {
        $locale = 'fr';
        $this->locale->setAllowed([$locale]);
        $this->locale->setLocale($locale);
        $this->assertEquals($locale, $this->locale->get());
        $this->assertEquals($locale, $this->locale->getLocale());
    }
    
    public function testAllowedGetSet(): void
    {
        $allowed = ['en', 'fr', 'new'];
        $this->locale->setAllowed($allowed);
        $this->assertEquals($allowed, $this->locale->getAllowed());
    }
    
    public function testGetDefaultValue(): void
    {
        $locale = null;
        $this->locale->setLocale($locale);
        $this->assertEquals($locale, $this->locale->get());
        $this->assertEquals($locale, $this->locale->getLocale());
    }
    
    public function testGetNonExistingValue(): void
    {
        $locale = 'not-allowed-locale';
        $this->locale->setLocale($locale);
        $this->assertNotEquals($locale, $this->locale->get());
        $this->assertNotEquals($locale, $this->locale->getLocale());
    }
    
    public function testPrepareDefault(): void
    {
        $locale = 'fr';
        $this->locale->setAllowed([$locale]);
        $this->locale->setDefault($locale);
        $this->locale->setMode(Locale::MODE_DEFAULT);
        $result = $this->locale->prepare($this->locale->getDefault());
        $this->assertEquals($locale, $result);
    }
    
    public function testPrepareHttp(): void
    {
        $locale = 'fr';
        $this->locale->setAllowed(['en', $locale]);
        $this->locale->setDefault('en');
        $this->locale->setMode(Locale::MODE_HTTP);
        
        // use best language
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'fr_CA';
        $result = $this->locale->prepare($this->locale->getDefault());
        $this->assertEquals($locale, $result);
        
        // fallback to default
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'sp_IT';
        $result = $this->locale->prepare($this->locale->getDefault());
        $this->assertEquals('en', $result);
    }
    
    public function testPrepareSession(): void
    {
        $locale = 'fr';
        $this->locale->setAllowed(['en', $locale]);
        $this->locale->setDefault('en');
        $this->locale->setMode(Locale::MODE_SESSION);
        
        // use session value
        $this->locale->saveIntoSession($locale, true);
        $result = $this->locale->prepare($this->locale->getDefault());
        $this->assertEquals($locale, $result);
        
        // fallback to default locale
        $this->locale->saveIntoSession('not-allowed-locale', true);
        $result = $this->locale->prepare($this->locale->getDefault());
        $this->assertEquals('en', $result);
    }
    
    public function testSessionGetSet(): void
    {
        $locale = 'fr';
        $this->locale->setAllowed(['en', $locale]);
        $this->locale->setDefault('en');
        
        $this->locale->saveIntoSession($locale, true);
        $this->assertEquals($locale, $this->locale->getFromSession($locale));
        
        $locale = 'not-allowed-locale';
        $this->locale->saveIntoSession($locale, true);
        $this->assertEquals(null, $this->locale->getFromSession());
        
        $locale = 'en';
        $this->locale->setMode(Locale::MODE_SESSION);
        $this->locale->saveIntoSession($locale);
        $this->assertEquals($locale, $this->locale->getFromSession());
    }
    
    public function testGetFromHttp(): void
    {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'fr_CA';
        $this->assertEquals('fr_CA', $this->locale->getFromHttp());
        
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
        $this->assertEquals('en', $this->locale->getFromHttp());
        
        // @todo fix this
//        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
//        $this->assertEquals('fr', $this->locale->getFromHttp('fr'));
    }
    
    public function testLookup(): void
    {
        $result = $this->locale->lookup('fr', ['fr'], false, 'fr');
        $this->assertEquals('fr', $result);
        
        $result = $this->locale->lookup('en', ['fr'], false, 'fr');
        $this->assertEquals('fr', $result);
        
        $result = $this->locale->lookup('en', ['fr', 'en'], false, 'fr');
        $this->assertEquals('en', $result);
        
        $result = $this->locale->lookup('eu', ['fr', 'en'], false, 'es');
        $this->assertEquals('es', $result);
        
        $result = $this->locale->lookup('eu', ['fr', 'en'], true, 'es');
        $this->assertEquals('es', $result);
        
        $result = $this->locale->lookup('fr_CA', ['fr', 'en'], true, 'es');
        $this->assertEquals('fr', $result);
        
        $result = $this->locale->lookup('fr_CA', ['fr_CA', 'en'], true, 'es');
        $this->assertEquals('fr_ca', $result);
        
        $result = $this->locale->lookup('fr_CA', ['fr_CA', 'en'], false, 'es');
        $this->assertEquals('fr_CA', $result);
        
        $result = $this->locale->lookup('fr_CA', ['fr', 'fr_CA'], false, 'es');
        $this->assertEquals('fr_CA', $result);
        
        $result = $this->locale->lookup('fr_CA', ['fr_CA', 'fr'], false, 'es');
        $this->assertEquals('fr_CA', $result);
    }
}
