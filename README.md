# User Component

This library provides you a simple way to interact with a user over an application via a set of interfaces

0. [How to install](#0-installing-the-component)
1. [Interacting with the user](#1-interacting-with-the-user)
2. [Storing user](#2-storing-user)
3. [Loading user](#3-loading-user)
4. [Role hierarchy](#4-role-hierarchy)
5. [Contributing](#5-contributing)
6. [License](#6-license)

## 0. Installing the component

User library can be installed via composer

~~~bash
$ composer require ness/user
~~~

## 1. Interacting with the user

UserInterface allows you to interact with the user on multiple ways.

Let see a simple example implying the native implementation of this interface

~~~php
<?php
// initializing a simple user
$user = new User("Foo");
// that's it, now you have a user instance with Foo setted as its name

$name = $user->getName() // allow you to get the username

// this implementation implements __toString, so echoing the user is enough to output its name
echo $user // output Foo
~~~

### 1.1 Attributes

Attributes are simples values linked to a user allowing you to store more informations.

They can be setted during the user initialization and later altered via some methods.

#### 1.1.1 Accessing attributes

~~~php
<?php
// initializing user with already setted attributes
$user = new User("Foo", ["foo" => "bar"]);
// this user now has an attribute foo with a value bar

// attributes can be accessed is multiples ways
// getting all attributes
$attributes = $user->getAttributes(); // returns ["foo => "bar"]
// or a single one
$attributeFoo = $user->getAttribute("foo") // returns bar
~~~

Trying to get all attributes from a user who has no attributes at all will result null. <br />
Trying to get a non setted attribute will as well result null.

~~~php
$user = new User("Foo");

$user->getAttributes(); // returns null
$user->getAttribute("foo") // returns null as well
~~~

#### 1.1.2 Altering user's attributes

Attributes, as already said, can be altered after the user has been initialized. 

The implementation via its interface allows you to add and delete attributes whenever you want

~~~php
<?php
// let's initialize an empty user
$user = new User("Foo");

// adding a foo attribute into the user
$user->addAttribute("foo", "bar);
$user->getAttribute("foo"); // returns bar

// deleting the setted foo attribute
$user->deleteAttribute("foo") // foo attribute detached from the user
~~~

**! Important !**

Attribute name is restricted to a certain pattern (a-zA-Z0-9_) described into the interface and MUST be compliant with it. <br />
The native implementation of UserInterface restricts types given as an attribute value, therefore no anonymous object or function or resource can be setted.

Trying to set an invalid name or one of this invalid value as an attribute for this implementation will result a InvalidUserAttributeValueException. 

### 1.2 Roles

Roles are simple values setted into the user. <br />
Can be useful for allowing/disallowing him access to some features of the application.

~~~php
<?php
// let's initialize a user
$user = new User("Foo", null, ["ANONYMOUS", "MEMBER"]);
// now we have a user with two roles setted

// getting all roles
$roles = $user->getRoles(); // returns ["ANONUMOUS", "MEMBER]

// checking if a user has a specific role
$hasRoleMember = $user->hasRole("MEMBER"); // setted to true
$hasRoleAdmin = $user->hasRole("ADMIN") // setted to false
~~~

Once the user has been initialized, the interface and this implementation does not allow you to update the roles already defined.

## 2. Storing user

User store allows you to persist a user during its navigation in your application to interact with it.

The interface provides you some methods to achieve that.

~~~php
<?php
$user = new User("Foo");

// store initialization
$store = new UserStorageImplementation();

// storing a user for the current navigation
$store->store($user); // returns a boolean

// getting the stored user
$store->get(); // will return, in this case, the user Foo

// refreshing the user
$refreshedUser = new User("Foo", ["foo", "bar"]);
$store->refresh($refreshedUser); // user Foo has been refreshed

// deleting the user
$store->delete(); // the user Foo has been popped out of the store

// trying to get a non store user will result a null return
$store->get(); user has been popped out previously from the store, returns null in this case
~~~

### 2.1 NativeSessionUserStorage

This library comes with a simple implementation of UserStorageInterface using the native php session mechanism.

**Session MUST be active or a LogicException will be thrown.**

## 3. Loading user

A user loader allow you to retrieve a user by its name from an external storage where all informations about your users are.

The interface consists in a simple method loadUser();

**Trying to get a non reachable user will result a UserNotFoundException**

### 3.1 ArrayPhpFileUserLoader

This library allows you via the ArrayPhpFileUserLoader class to retrieve a specific user from arrays or files returning an array.

Let's see an example implying usage of the two ways.

~~~php
<?php
// members.users.php

// list of all members of my application
return [
    "FooUser"    =>    [
        "attributes"    =>    [
            "foo"           =>    "bar"    
        ],
        "roles"         =>    [
            "MEMBER"
        ]
    ],
    "BarUser"    =>    [
        "attributes"    =>    [
            "foo"           =>    "bar"    
        ],
        "roles"         =>    [
            "MEMBER",
            "MODERATOR"
        ]
    ]
];
~~~

Now let's initialize the loader

~~~php
<?php
$adminUsers = [
    "AdminUserFoo"    =>    [
        "roles"           =>    [
            "ADMIN"
        ]
    ],
    "AdminUserBar"    =>    [
        "roles"           =>    [
            "ADMIN"
        ]
    ]
];

$loader = new ArrayPhpFileUserLoader([$adminUsers, ./foo/bar/members.users.php]);

// this configuration allows you to load FooUser, BarUser, AdminUserFoo and AdminUserBar

// loading FooUser
$fooUser = $loader->loadUser("FooUser");

// FooUser is initialized with the attribute foo and a single MEMBER role

// loading BarUser
$barUser = $loader->loadUser("BarUser");

// BarUser is initialized with the attribute foo and a two roles MEMBER and MODERATOR

// loading from the given array
$adminFoo = $loader->loadUser("AdminUserFoo");
$adminBar = $loader->loadUser("AdminUserBar");

// both, in this case, users are initialized with no attribute and an ADMIN role setted
~~~

### 2.2 UserLoaderCollection

The UserLoaderCollection is a simple container registering a set of UserLoaderInterface implementations doing its best to find a loadable user from all registered loaders.

~~~php
<?php
// let's assume all members are loadables via this loader
$loaderMember = new UserLoaderImplementation();

// and via this one provides all admins
$loaderAdmin = new UserLoaderImplementation();

// now let's configure the UserLoaderCollection
$loader = new UserLoaderCollection($loaderMember);
$loader->addLoader($loaderAdmin);
// that's it

$user = $loader->loadUser("MemberFoo"); // found into the first loader ($loaderMember), therefore MemberFoo is initialize from this one
$admin = $loader->loadUser("AdminFoo"); // not found into the first loader, so the collection dump to the next, found it and initialize it
~~~

That was an abstract representation of the UserLoaderCollection, but we can imagine wanting to load users from multiple sources without the need to always provide a specific one each time.

## 4. Role hierarchy

Sometimes, it can be useful for a role to inherit from one or multiple roles therefore granting rigths (for example) over your application for the given role all all its parents.

RoleHierachyInterface allows you to set this behaviour and get for a specific role all its parents.

Trying to get a non setted role from the hierarchy will result a UndefinedRoleException.

### 4.1 Role hierarchy

To initialize a role hierarchy, this library provides you a simple implementation or RoleHierarchyInterface.

~~~php
<?php
$hierarchy = new RoleHierarchy();

// let's add some basics roles
$hierarchy->addRole("BaseFooRole");
$hierarchy->addRole("BaseBarRole");

// now some inherited roles
$hierarchy->addRole("FooRole", ["BaseFooRole"]);
$hierarchy->addRole("BarRole", ["BaseBarRole"]);
$hierarchy->addRole("KekRole", ["FooRole", "BarRole"]);

// this will throw a UndefinedRoleException as InvalidParent is not setted
$hierarchy->addRole("InvalidRole", ["InvalidParent"]);

// now let's get a role
$hierarchy->getRole("BaseFooRole"); // will simply return ["BaseFooRole"]
$hierarchy->getRole("FooRole"); // will return ["FooRole", "BaseFooRole"]
$hierarchy->getRole("KekRole") // will return ["KekRole", "FooRole", "BaseFooRole", "BarRole", "BaseBarRole"]

// same as declaring a non setted parent role, trying to get a non setted role from the hierarchy will result a UndefinedRoleException
$hierarchy->getRole("InvalidRole");
~~~

### 4.2 Linking a user to a role hierarchy

A more user friendly interface (RoleHierarchyUserInteractionInterface) provides you a way to interact directly with a user instead of checking all roles of a user over the role hierarchy.

This interface extends directly from the RoleHierarchyInterface and requires a user setted via the UserAwareInterface.

~~~php
<?php
// simple example
$hierarchy = new RoleHierarchyUserInteraction();
$hierarchy->addRole("BaseFooRole");
$hierarchy->addRole("BaseBarRole");
$hierarchy->addRole("FooRole", ["BaseFooRole"]);
$hierarchy->addRole("BarRole", ["BaseBarRole"]);
$hierarchy->addRole("KekRole", ["FooRole", "BarRole"]);

// now imagine we had this user
$user = new User("Foo", null, ["KekRole"]);

// checking if the user has role BaseFooRole
$user->hasRole("BaseFooRole") // will return false...

// if we use the role hierarchy
$hierarchy->setUser($user);
$hierarchy->userHasRole("BaseFooRole") // will return true as expected
~~~


## 5. Contributing

Found something **wrong** (nothing is perfect) ? Wanna talk or participate ? <br />
Issue the case or contact me at [curtis_barogla@outlook.fr](mailto:curtis_barogla@outlook.fr)

## 6. License

The Ness User component is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
