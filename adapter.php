<?php
/*
Adapter Design Pattern

Intent

Convert the interface of a class into another interface clients expect. Adapter lets classes work together that couldn't otherwise because of incompatible interfaces.
Wrap an existing class with a new interface.
Impedance match an old component to a new system
Problem

An "off the shelf" component offers compelling functionality that you would like to reuse, but its "view of the world" is not compatible with the philosophy and architecture of the system currently being developed.

Discussion

Reuse has always been painful and elusive. One reason has been the tribulation of designing something new, while reusing something old. There is always something not quite right between the old and the new. It may be physical dimensions or misalignment. It may be timing or synchronization. It may be unfortunate assumptions or competing standards.

It is like the problem of inserting a new three-prong electrical plug in an old two-prong wall outlet – some kind of adapter or intermediary is necessary.

Adapter real example

Adapter is about creating an intermediary abstraction that translates, or maps, the old component to the new system. Clients call methods on the Adapter object which redirects them into calls to the legacy component. This strategy can be implemented either with inheritance or with aggregation.

Adapter functions as a wrapper or modifier of an existing class. It provides a different or translated view of that class.

Structure

Below, a legacy Rectangle component's display() method expects to receive "x, y, w, h" parameters. But the client wants to pass "upper left x and y" and "lower right x and y". This incongruity can be reconciled by adding an additional level of indirection – i.e. an Adapter object.

Scheme of Adapter

The Adapter could also be thought of as a "wrapper".

Scheme of Adapter

Example

The Adapter pattern allows otherwise incompatible classes to work together by converting the interface of one class into an interface expected by the clients. Socket wrenches provide an example of the Adapter. A socket attaches to a ratchet, provided that the size of the drive is the same. Typical drive sizes in the United States are 1/2" and 1/4". Obviously, a 1/2" drive ratchet will not fit into a 1/4" drive socket unless an adapter is used. A 1/2" to 1/4" adapter has a 1/2" female connection to fit on the 1/2" drive ratchet, and a 1/4" male connection to fit in the 1/4" drive socket.

Example of Adapter

Check list

Identify the players: the component(s) that want to be accommodated (i.e. the client), and the component that needs to adapt (i.e. the adaptee).
Identify the interface that the client requires.
Design a "wrapper" class that can "impedance match" the adaptee to the client.
The adapter/wrapper class "has a" instance of the adaptee class.
The adapter/wrapper class "maps" the client interface to the adaptee interface.
The client uses (is coupled to) the new interface
Rules of thumb

Adapter makes things work after they're designed; Bridge makes them work before they are.
Bridge is designed up-front to let the abstraction and the implementation vary independently. Adapter is retrofitted to make unrelated classes work together.
Adapter provides a different interface to its subject. Proxy provides the same interface. Decorator provides an enhanced interface.
Adapter is meant to change the interface of an existing object. Decorator enhances another object without changing its interface. Decorator is thus more transparent to the application than an adapter is. As a consequence, Decorator supports recursive composition, which isn't possible with pure Adapters.
Facade defines a new interface, whereas Adapter reuses an old interface. Remember that Adapter makes two existing interfaces work together as opposed to defining an entirely new one.

*/

/*

In the Adapter Design Pattern, a class converts the interface of one class to be what another class expects.

In this example we have a SimpleBook class that has a getAuthor() and getTitle() methods. The client, expects a getAuthorAndTitle() method. To "adapt" SimpleBook for testAdapter we have an adapter class, BookAdapter, which takes in an instance of  SimpleBook, and uses the SimpleBook getAuthor() and getTitle() methods in it's own  getAuthorAndTitle() method.

Adapters are helpful if you want to use a class that doesn't have quite the exact methods you need, and you can't change the orignal class. The adapter can take the methods you can access in the original class, and adapt them into the methods you need.
*/
class SimpleBook {
    private $author;
    private $title;
    function __construct($author_in, $title_in) {
        $this->author = $author_in;
        $this->title  = $title_in;
    }
    function getAuthor() {
        return $this->author;
    }
    function getTitle() {
        return $this->title;
    }
}

class BookAdapter {
    private $book;
    function __construct(SimpleBook $book_in) {
        $this->book = $book_in;
    }
    function getAuthorAndTitle() {
        return $this->book->getTitle().' by '.$this->book->getAuthor();
    }
}

  // client

  writeln('BEGIN TESTING ADAPTER PATTERN');
  writeln('');

  $book = new SimpleBook("Gamma, Helm, Johnson, and Vlissides", "Design Patterns");
  $bookAdapter = new BookAdapter($book);
  writeln('Author and Title: '.$bookAdapter->getAuthorAndTitle());
  writeln('');

  writeln('END TESTING ADAPTER PATTERN');

  function writeln($line_in) {
    echo $line_in."<br/>";
  }

?>