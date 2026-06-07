# Changelog

All notable changes to this project will be documented in this file.

## [2.2.12] - 2026-06-07

### Added

- Darmowa wysyłka dla klientów z zachowaniem wewnętrznego rozliczania rzeczywistego kosztu InPost według klasy wysyłki produktu.
- Nowy banner na stronie głównej z możliwością zamknięcia, zapamiętywaną w `sessionStorage` na czas bieżącej sesji przeglądarki.
- Kolumna „Koszt wysyłki” w panelu administracyjnym produktów oraz zapisywanie kosztu i etykiety klasy wysyłki do pozycji zamówienia.

### Changed

- Odczyt kosztu wysyłki dla klasy produktu został oparty wyłącznie o natywne ustawienia metod wysyłki WooCommerce (instance settings, np. `class_cost_TERM_ID`).

### Fixed

- Usunięto hardcoded ceny klas wysyłki i fallbacki cenowe z logiki motywu.
- Poprawiono odczyt kosztów tak, aby działał również dla metody InPost (`easypack_parcel_machines`), a nie tylko dla `flat_rate`.
- Cena produktu jest teraz automatycznie powiększana o koszt przypisanej klasy wysyłkowej z konfiguracji WooCommerce, dzięki czemu klient widzi cenę końcową już na stronie produktu i w koszyku.

## [2.2.11] - 2026-05-31

### Added

- Promocja: mycie płyt winylowych GRATIS — czerwony badge przy cenie na stronie produktu winylowego zastępuje checkbox z dopłatą +10 zł; układ flex (kolumna na mobile, wiersz od md); oryginalna funkcjonalność checkboxa zachowana w kodzie, gotowa do reaktywacji po zakończeniu promocji

## [2.2.10] - 2026-05-02

### Added

- Blok „Czego szukają nasi klienci?" na stronie głównej — 25 pill-linków pogrupowanych w 5 kategorii tematycznych (Szkło artystyczne, Żelastwo i kuchnia, Wagi zabytkowe, Narzędzia i sprzęt, Oświetlenie i dekoracje), oparty na danych z Google Search Console; każdy tag linkuje do wyników wyszukiwania produktów

## [2.2.9] - 2026-05-02

### Fixed

- Karuzela produktów na stronie głównej: wyrównanie wysokości slajdów przez `aspect-ratio: 4/5` i `object-fit: cover` — eliminuje nierówne odstępy przy różnych formatach zdjęć

## [2.2.8] - 2025

### Added

- Przyciski udostępniania w mediach społecznościowych na stronie pojedynczego produktu

## [2.2.3] - 2025

### Added

- Przyciski social share w stopce
- Wykluczanie produktów niedostępnych (out-of-stock) z zapytań produktowych

## [2.1.4] - 2025

### Added

- Wyświetlanie klasyfikacji na stronie archiwum i pojedynczego produktu
- Sortowanie alfabetyczne listingów produktów

### Changed

- Poprawki layoutu szablonów archiwum i produktu

## [2.1.2] - 2025

### Added

- Nowe style przycisków w koszyku
- Poprawki formularza kuponów w SCSS

## [2.1.1] - 2025

### Added

- Link „Blog" w stopce i nawigacji mobilnej
- Style dla szablonu strony blogowej

## [2.1.0] - 2025

### Added

- Schema klasyfikacji winyli dla SEO (RankMath breadcrumbs)
- Dynamiczne ładowanie assetów ACF na podstawie używanych layoutów w flexible content

## [1.4.4] - 2025

### Changed

- Dynamiczne tytuły kategorii i nagłówki filtrów w archiwum produktów

## [1.3.4] - 2025

### Added

- Wyróżnianie produktów niedostępnych w listingu

### Changed

- Poprawki dostępności (accessibility) w całym serwisie

## [1.3.3] - 2025

### Added

- Blokada możliwości zakupu dla produktów z klasą wysyłki „individual"
- Ukrywanie rat Przelewy24 dla tych produktów

## [1.3.2] - 2025

### Added

- Styl blockquote

### Changed

- Aktualizacja treści stopki, poprawki czytelności i responsywności

## [1.2.2] - 2025

### Changed

- Refaktor stylów strony pojedynczego produktu: responsywność, galeria, sticky bar

## [1.2.1] - 2025

### Changed

- Poprawki layoutu i paddingów szablonów produktu, kolekcji i kontaktu

## [1.2.0] - 2025

### Added

- Infinite scroll na archiwum produktów
- REST API endpoint `/wp-json/fajnestarocie/v1/products`

## [1.1.26] - 2025

### Added

- Strona 404 i wyszukiwarka z polską treścią
- Style koszyka i sticky bar

### Changed

- Refaktor struktury szablonów

## [1.0.4] - 2025-09-07

### Added

- Vite build system integration
- TailwindCSS support
- GSAP animations on homepage
- Swiper slider component

### Changed

- Refactored theme structure to use modern build tools
- Improved performance with optimized assets
- Updated styling system to use TailwindCSS

### Fixed

- Mobile menu display issues
- Product gallery layout on smaller screens
