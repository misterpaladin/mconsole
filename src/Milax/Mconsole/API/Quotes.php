<?php

namespace Milax\Mconsole\API;

class Quotes
{
    public $quotes = [
        [
            'text' => 'Нужно больше контента!',
            'author' => 'жадный менеджер',
        ],
        [
            'text' => 'Владеешь контентом — владеешь сайтом',
            'author' => 'маркетолог-победитель',
        ],
        [
            'text' => 'Mconsole — загружай и тести',
            'author' => 'ленивый кодер',
        ],
        [
            'text' => 'Нажми на кпопку и получишь.. результат',
            'author' => 'группа Технология',
        ],
        [
            'text' => 'Теперь с сайтом справится даже водитель',
            'author' => 'жадный заказчик',
        ],
        [
            'text' => 'Надо потестить поглубже',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Только снег нельзя вырубить через админку',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Газета была эпицентром всех несчастий сайта. Газета и Вован',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Это будет просто поправить, если надо',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Mconsole: для обладателей нетрудолюбивого пальца',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Мелочевку всегда надо двигать вперед остальных дел, а не тянуть сколько получится',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Ты запустил процесс, который перемелет все баги (когда-нибудь)',
            'author' => 'Ленивый кодер',
        ],
        [
            'text' => 'Она долго и упорно клянчила пароль от админки, пришлось дать',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Я б тут жил',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Тебе надо сделать один клик',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Да надо не забывать, а делать быстренько мелочи',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Думаешь само рассосется, если сидеть?',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Аа, ну это объясняет количество «СРОЧНО!» в этом месяце',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Это неловкое чувство, когда пишешь тесты для юнит тестов',
            'author' => 'Криворукий программист',
        ],
        [
            'text' => 'Mconsole: там контента на век еще хватит',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Вам нравится, то чем вы здесь занимаетесь',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Воздушный код, никаких багов',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Невозможно тут создать новое меню или я плохой админ?',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Главное что? Возможность отправить баг-репорт',
            'author' => 'Д. Баранов',
        ],
        [
            'text' => 'Ты такое неиспорченный. Разные тире, фотки в пдф... Чем бы тебя убить?',
            'author' => 'Д. Баранов',
        ],
    ];
    
    public $random;
    
    /**
     * Create new Quotes instance
     */
    public function __construct()
    {
        $this->quotes = collect($this->quotes);
    }
    
    /**
     * Get all quotes
     * 
     * @return Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->quotes;
    }
    
    /**
     * Get random quote
     * 
     * @return array
     */
    public function getRandom()
    {
        return $this->quotes->random();
    }
    
    /**
     * Shuffle quotes, set random quote in $this->random
     * 
     * @return void
     */
    public function shuffle()
    {
        $random = $this->quotes->random();
        $this->random = $random;
    }
    
    /**
     * Get random quote text
     * 
     * @return string
     */
    public function getText()
    {
        return $this->random['text'];
    }
    
    /**
     * Get random quote author
     * 
     * @return string
     */
    public function getAuthor()
    {
        return $this->random['author'];
    }
}
