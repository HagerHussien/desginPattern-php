<?php
/*
Factory Method Design Pattern

Intent

Define an interface for creating an object, but let subclasses decide which class to instantiate. Factory Method lets a class defer instantiation to subclasses.
Defining a "virtual" constructor.
The new operator considered harmful.
Problem

A framework needs to standardize the architectural model for a range of applications, but allow for individual applications to define their own domain objects and provide for their instantiation.

Discussion

Factory Method is to creating objects as Template Method is to implementing an algorithm. A superclass specifies all standard and generic behavior (using pure virtual "placeholders" for creation steps), and then delegates the creation details to subclasses that are supplied by the client.

Factory Method makes a design more customizable and only a little more complicated. Other design patterns require new classes, whereas Factory Method only requires a new operation.

People often use Factory Method as the standard way to create objects; but it isn't necessary if: the class that's instantiated never changes, or instantiation takes place in an operation that subclasses can easily override (such as an initialization operation).

Factory Method is similar to Abstract Factory but without the emphasis on families.

Factory Methods are routinely specified by an architectural framework, and then implemented by the user of the framework.

Structure

The implementation of Factory Method discussed in the Gang of Four (below) largely overlaps with that of Abstract Factory. For that reason, the presentation in this chapter focuses on the approach that has become popular since.

Scheme of Factory Method

An increasingly popular definition of factory method is: a static method of a class that returns an object of that class' type. But unlike a constructor, the actual object it returns might be an instance of a subclass. Unlike a constructor, an existing object might be reused, instead of a new object created. Unlike a constructor, factory methods can have different and more descriptive names (e.g. Color.make_RGB_color(float red, float green, float blue) and Color.make_HSB_color(float hue, float saturation, float brightness)

Scheme of Factory Method

The client is totally decoupled from the implementation details of derived classes. Polymorphic creation is now possible.


Example

The Factory Method defines an interface for creating objects, but lets subclasses decide which classes to instantiate. Injection molding presses demonstrate this pattern. Manufacturers of plastic toys process plastic molding powder, and inject the plastic into molds of the desired shapes. The class of toy (car, action figure, etc.) is determined by the mold.

Example of Factory Method

Check list

If you have an inheritance hierarchy that exercises polymorphism, consider adding a polymorphic creation capability by defining a static factory method in the base class.
Design the arguments to the factory method. What qualities or characteristics are necessary and sufficient to identify the correct derived class to instantiate?
Consider designing an internal "object pool" that will allow objects to be reused instead of created from scratch.
Consider making all constructors private or protected.

Rules of thumb:

Abstract Factory classes are often implemented with Factory Methods, but they can be implemented using Prototype.
Factory Methods are usually called within Template Methods.
Factory Method: creation through inheritance. Prototype: creation through delegation.
Often, designs start out using Factory Method (less complicated, more customizable, subclasses proliferate) and evolve toward Abstract Factory, Prototype, or Builder (more flexible, more complex) as the designer discovers where more flexibility is needed.
Prototype doesn't require subclassing, but it does require an Initialize operation. Factory Method requires subclassing, but doesn't require Initialize.
The advantage of a Factory Method is that it can return the same instance multiple times, or can return a subclass rather than an object of that exact type.
Some Factory Method advocates recommend that as a matter of language design (or failing that, as a matter of style) absolutely all constructors should be private or protected. It's no one else's business whether a class manufactures a new object or recycles an old one.
The new operator considered harmful. There is a difference between requesting an object and creating one. The new operator always creates an object, and fails to encapsulate object creation. A Factory Method enforces that encapsulation, and allows an object to be requested without inextricable coupling to the act of creation.

*/
/*
In the Factory Method Pattern, a factory method defines what functions must be available in the non-abstract or concrete factory. These functions must be able to create objects that are extensions of a specific class. Which exact subclass is created will depend on the value of a parameter passed to the function.

In this example we have a factory method, AbstractFactoryMethod, that specifies the function, makePHPBook($param).

The concrete class OReillyFactoryMethod factory extends AbstractFactoryMethod, and can create the correct the extension of the AbstractPHPBook class for a given value of  $param.

*/

abstract class AbstractFactoryMethod {
    abstract function makePHPBook($param);
}

class OReillyFactoryMethod extends AbstractFactoryMethod {
    private $context = "OReilly";  
    function makePHPBook($param) {
    $book = NULL;   
        switch ($param) {
            case "us":
                $book = new OReillyPHPBook;
            break;
            case "other":
                $book = new SamsPHPBook;
            break;
            default:
                $book = new OReillyPHPBook;
            break;        
        }     
    return $book;
    }
}

class SamsFactoryMethod extends AbstractFactoryMethod {
    private $context = "Sams";
    function makePHPBook($param) {
        $book = NULL;
        switch ($param) {
            case "us":
                $book = new SamsPHPBook;
            break;      
            case "other":
                $book = new OReillyPHPBook;
            break;
            case "otherother":
                $book = new VisualQuickstartPHPBook;
            break;
            default:
                $book = new SamsPHPBook;
            break;    
        }     
        return $book;
    }
}

abstract class AbstractBook {
    abstract function getAuthor();
    abstract function getTitle();
}

abstract class AbstractPHPBook {
    private $subject = "PHP";
}

class OReillyPHPBook extends AbstractPHPBook {
    private $author;
    private $title;
    private static $oddOrEven = 'odd';
    function __construct() {
        //alternate between 2 books
        if ('odd' == self::$oddOrEven) {
            $this->author = 'Rasmus Lerdorf and Kevin Tatroe';
            $this->title  = 'Programming PHP';
            self::$oddOrEven = 'even';
        } else {
            $this->author = 'David Sklar and Adam Trachtenberg';
            $this->title  = 'PHP Cookbook'; 
            self::$oddOrEven = 'odd';
        }  
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}

class SamsPHPBook extends AbstractPHPBook {
    private $author;
    private $title;
    function __construct() {
        //alternate randomly between 2 books
        mt_srand((double)microtime()*10000000);
        $rand_num = mt_rand(0,1);      
 
        if (1 > $rand_num) {
            $this->author = 'George Schlossnagle';
            $this->title  = 'Advanced PHP Programming';
        } else {
            $this->author = 'Christian Wenz';
            $this->title  = 'PHP Phrasebook'; 
        }  
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}

class VisualQuickstartPHPBook extends AbstractPHPBook {
    private $author;
    private $title;
    function __construct() {
      $this->author = 'Larry Ullman';
      $this->title  = 'PHP for the World Wide Web';
    }
    function getAuthor() {return $this->author;}
    function getTitle() {return $this->title;}
}

  writeln('START TESTING FACTORY METHOD PATTERN');
  writeln('');

  writeln('testing OReillyFactoryMethod');
  $factoryMethodInstance = new OReillyFactoryMethod;
  testFactoryMethod($factoryMethodInstance);
  writeln('');

  writeln('testing SamsFactoryMethod');
  $factoryMethodInstance = new SamsFactoryMethod;
  testFactoryMethod($factoryMethodInstance);
  writeln('');

  writeln('END TESTING FACTORY METHOD PATTERN');
  writeln('');

  function testFactoryMethod($factoryMethodInstance) {
    $phpUs = $factoryMethodInstance->makePHPBook("us");
    writeln('us php Author: '.$phpUs->getAuthor());
    writeln('us php Title: '.$phpUs->getTitle());

    $phpUs = $factoryMethodInstance->makePHPBook("other");
    writeln('other php Author: '.$phpUs->getAuthor());
    writeln('other php Title: '.$phpUs->getTitle());
 
    $phpUs = $factoryMethodInstance->makePHPBook("otherother");
    writeln('otherother php Author: '.$phpUs->getAuthor());
    writeln('otherother php Title: '.$phpUs->getTitle());
  }

  function writeln($line_in) {
    echo $line_in."<br/>";
  }
?>