# Database Schema


## 1. Wishlist
| **Field**   | **Data Type**     | **Description**     |
|-------------|-------------------|---------------------|
| ID          | `VARCHAR(20)`     | Wishlist ID         |
| User_ID     | `VARCHAR(20)`     | User ID             |
| Product_ID  | `VARCHAR(20)`     | Product ID          |
| Price       | `INT(50)`         | Product price       |

## 3. Users
| **Field**   | **Data Type**     | **Description**     |
|-------------|-------------------|---------------------|
| ID          | `VARCHAR(20)`     | User ID             |
| Name        | `VARCHAR(50)`     | User name           |
| Email       | `VARCHAR(100)`    | User email          |
| phone_number| `VARCHAR(100)`    | User email          |
| Password    | `VARCHAR(50)`     | User password       |
| User_Type   | `VARCHAR(100)`    | User type           |

## 4. Products
| **Field**        | **Data Type**     | **Description**          |
|-------------------|-------------------|--------------------------|
| ID               | `VARCHAR(20)`     | Product ID               |
| Name             | `VARCHAR(250)`    | Product name             |
| Price            | `INT(50)`         | Product price            |
| Product_Detail   | `VARCHAR(1000)`   | Product description      |
| Status           | `VARCHAR(100)`    | Product status           |

## 5. Orders
| **Field**         | **Data Type**     | **Description**          |
|--------------------|-------------------|--------------------------|
| ID                | `VARCHAR(20)`     | Order ID                 |
| User_ID           | `VARCHAR(20)`     | User ID                  |
| Name              | `VARCHAR(100)`    | Name on the order        |
| Number            | `INT(20)`         | Contact number           |
| Email             | `VARCHAR(100)`    | Email address            |
| Address           | `VARCHAR(500)`    | Shipping address         |
| Address_Type      | `VARCHAR(10)`     | Address type             |
| Method            | `VARCHAR(50)`     | Payment method           |
| Product_ID        | `VARCHAR(20)`     | Product ID               |
| Price             | `INT(10)`         | Total price              |
| Quantity          | `VARCHAR(2)`      | Product quantity         |
| Date              | `DATE`            | Order date *(Default: CURRENT_TIME)* |
| Status            | `VARCHAR(50)`     | Order status             |
| Payment_Status    | `VARCHAR(100)`    | Payment status           |

## 6. Message
| **Field**   | **Data Type**     | **Description**     |
|-------------|-------------------|---------------------|
| ID          | `VARCHAR(20)`     | Message ID          |
| User_ID     | `VARCHAR(20)`     | User ID             |
| Name        | `VARCHAR(50)`     | User name           |
| Email       | `VARCHAR(100)`    | User email          |
| Subject     | `VARCHAR(255)`    | Message subject     |
| Message     | `VARCHAR(1000)`   | Message content     |

## 7. Cart
| **Field**   | **Data Type**     | **Description**     |
|-------------|-------------------|---------------------|
| ID          | `VARCHAR(20)`     | Cart ID             |
| User_ID     | `VARCHAR(20)`     | User ID             |
| Product_ID  | `VARCHAR(20)`     | Product ID          |
| Price       | `INT(10)`         | Product price       |
| Quantity    | `INT(2)`          | Quantity *(Default: 1)* |
