<?php

/*
Template Name: Klasyfikacja winyli
*/

?>

<?php get_header();

$email = get_field('email', 'option'); 

?>


<section class="relative py-12 lg:pt-20 lg:py-32 lg:pb-0 border border-dashed overflow-hidden bg-stone-200">
    <div class="container mx-auto px-4 relative">
        <div class="max-w-6xl mx-auto text-center">

            <p class="text-md  opacity-60">
            </p>
            <p class="text-xl py-4 mx-auto italic">Witamy na dziale naszego sklepu który jest dla nas
                szczególnie ważny... Poszukując ciekawych i ładnych przedmiotów zawsze zwracamy
                uwagę na <strong><a class="hvr-underline" href="<?php echo home_url();  ?>/kategoria/winyle/"
                        target="_blank">płyty
                        winylowe</a></strong>.
                Ich szczególny czar
                spowodował, iż mamy dla nich szczególne miejsce w naszym sklepie.</p>
            <h1 class="font-heading text-5xl sm:text-6xl mt-12 mb-4">Jak klasyfikujemy winyle?</h1>
            <h2>Płyty klasyfikujemy wg. poniższych kategorii:</h2>


            <ul class="list-disc list-inside text-left mt-6 ">
                <li><span class="font-bold">M – Mint</span>– nowa </li>
                <li><span class="font-bold">NM – Near Mint</span> – prawie nowa - bez większych oznak używania, pełna
                    jakość dźwięku, okładka prawie jak nowa,</li>
                <li><span class="font-bold">EX – Exellent</span> – posiada lekkie oznaki używania, mogą występować
                    lekkie
                    ryski, sporadyczne trzaski, zmniejszenie jakości dźwięku jest niewielkie, okładka posiada oznaki
                    użytkowania,</li>
                <li><span class="font-bold">VG – Very good </span> – bardzo dobra – wielokrotnie odtwarzana, ślady
                    eksploatacyjne normalnego użytkowania, płytkie rysy i przetarcia, nie przeskakuje, nie zawiesza się,
                    można sporadycznie usłyszeć lekkie trzaski i smażenie, okładka może posiadać niewielkie przetarcia
                    na krawędziach i rogach, dopuszczalne lekkie przebarwienia szaty graficznej okładki,</li>
                <li><span class="font-bold">G – Good </span> – dobra – płyta nosi ślady częstego odtwarzania, może
                    posiadać widoczne głębsze rysy, mogą pojawiać się szumy i trzaski podczas odtwarzania, dopuszczalne
                    niewielkie przeskoki.</li>
            </ul>

            <footer class="mt-6 text-left">
                <p>W kategoriach <strong>NM</strong>, <strong>EX</strong>, <strong>VG</strong> i <strong>G</strong>
                    stosujemy – w określonych przypadkach - doprecyzowania (+) lub (-) w
                    zależności od stanu płyty oraz okładki. W wyjątkowych sytuacjach, np. świetny stan płyty (NM),
                    natomiast
                    słaby okładki G ( np. sklejony album w wyniku długotrwałego przechowywania) osobno określamy stan
                    płyty
                    i okładki, zgodnie z powyższą klasyfikacją. Dodatkowo stan okładki </p>

                <p>staramy się dobrze pokazać na zdjęciach, Płyty są zawsze pakowane w nowe koszulki antystatyczne.</p>
            </footer>

        </div>
    </div>
</section>

<div class="my-6 lg:my-16">
    <?php get_template_part('template-parts/clean-winyls-banner'); ?>
</div>

<?php get_footer(); ?>