<?php
/*
Template Method Design Pattern

Intent

Define the skeleton of an algorithm in an operation, deferring some steps to client subclasses. Template Method lets subclasses redefine certain steps of an algorithm without changing the algorithm's structure.
Base class declares algorithm 'placeholders', and derived classes implement the placeholders.
Problem

Two different components have significant similarities, but demonstrate no reuse of common interface or implementation. If a change common to both components becomes necessary, duplicate effort must be expended.

Discussion

The component designer decides which steps of an algorithm are invariant (or standard), and which are variant (or customizable). The invariant steps are implemented in an abstract base class, while the variant steps are either given a default implementation, or no implementation at all. The variant steps represent "hooks", or "placeholders", that can, or must, be supplied by the component's client in a concrete derived class.

The component designer mandates the required steps of an algorithm, and the ordering of the steps, but allows the component client to extend or replace some number of these steps.

Template Method is used prominently in frameworks. Each framework implements the invariant pieces of a domain's architecture, and defines "placeholders" for all necessary or interesting client customization options. In so doing, the framework becomes the "center of the universe", and the client customizations are simply "the third rock from the sun". This inverted control structure has been affectionately labelled "the Hollywood principle" - "don't call us, we'll call you".

Structure

Template Method scheme

The implementation of template_method() is: call step_one(), call step_two(), and call  step_three().  step_two() is a "hook" method – a placeholder. It is declared in the base class, and then defined in derived classes. Frameworks (large scale reuse infrastructures) use Template Method a lot. All reusable code is defined in the framework's base classes, and then clients of the framework are free to define customizations by creating derived classes as needed.

Template Method scheme

Example

The Template Method defines a skeleton of an algorithm in an operation, and defers some steps to subclasses. Home builders use the Template Method when developing a new subdivision. A typical subdivision consists of a limited number of floor plans with different variations available for each. Within a floor plan, the foundation, framing, plumbing, and wiring will be identical for each house. Variation is introduced in the later stages of construction to produce a wider variety of models.

Another example: daily routine of a worker.

Template Method example

Check list

Examine the algorithm, and decide which steps are standard and which steps are peculiar to each of the current classes.
Define a new abstract base class to host the "don't call us, we'll call you" framework.
Move the shell of the algorithm (now called the "template method") and the definition of all standard steps to the new base class.
Define a placeholder or "hook" method in the base class for each step that requires many different implementations. This method can host a default implementation – or – it can be defined as abstract (Java) or pure virtual (C++).
Invoke the hook method(s) from the template method.
Each of the existing classes declares an "is-a" relationship to the new abstract base class.
Remove from the existing classes all the implementation details that have been moved to the base class.
The only details that will remain in the existing classes will be the implementation details peculiar to each derived class.
Rules of thumb

Strategy is like Template Method except in its granularity.
Template Method uses inheritance to vary part of an algorithm. Strategy uses delegation to vary the entire algorithm.
Strategy modifies the logic of individual objects. Template Method modifies the logic of an entire class.
Factory Method is a specialization of Template Method.

*/

/*

In the Template Pattern an abstract class will define a method with an algorithm, and methods which the algorithm will use. The methods the algorithm uses can be either required or optional. The optional method should by default do nothing.

The Template Pattern is unusual in that the Parent class has a lot of control.

In this example, the TemplateAbstract class has the showBookTitleInfo() method, which will call the methods getTitle() and getAuthor(). The method getTitle() must be overridden, while the method getAuthor() is not required.


*/
abstract class TemplateAbstract {
    //the template method 
    //  sets up a general algorithm for the whole class 
    public final function showBookTitleInfo($book_in) {
        $title = $book_in->getTitle();
        $author = $book_in->getAuthor();
        $processedTitle = $this->processTitle($title);
        $processedAuthor = $this->processAuthor($author);
        if (NULL == $processedAuthor) {
            $processed_info = $processedTitle;
        } else {
            $processed_info = $processedTitle.' by '.$processedAuthor;
        }
        return $processed_info;
    }
    //the primitive operation
    //  this function must be overridden
    abstract function processTitle($title);
    //the hook operation
    //  this function may be overridden, 
    //  but does nothing if it is not
    function processAuthor($author) {
        return NULL;
    } 
}

class TemplateExclaim extends TemplateAbstract {
    function processTitle($title) {
      return Str_replace(' ','!!!',$title); 
    }
    function processAuthor($author) {
      return Str_replace(' ','!!!',$author);
    }
}

class TemplateStars extends TemplateAbstract {
    function processTitle($title) {
        return Str_replace(' ','*',$title); 
    }
}

class Book {
    private $author;
    private $title;
    function __construct($title_in, $author_in) {
        $this->author = $author_in;
        $this->title  = $title_in;
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
    function getAuthorAndTitle() {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

  writeln('BEGIN TESTING TEMPLATE PATTERN');
  writeln('');
 
  $book = new Book('PHP for Cats','Larry Truett');
 
  $exclaimTemplate = new TemplateExclaim();  
  $starsTemplate = new TemplateStars();
 
  writeln('test 1 - show exclaim template');
  writeln($exclaimTemplate->showBookTitleInfo($book));
  writeln('');

  writeln('test 2 - show stars template');
  writeln($starsTemplate->showBookTitleInfo($book));
  writeln('');

  writeln('END TESTING TEMPLATE PATTERN');

  function writeln($line_in) {
    echo $line_in."<br/>";
  }

?>