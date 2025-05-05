-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 06:37 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookcorner`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', '867828277d8660bbb44ebbd860d2f020'),
(2, 'Nibah Kondvilkar', 'nibah', 'f2191f9974f86242703de889c50651cb');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `genre_id` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `copies_available` int(11) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `title`, `author`, `description`, `genre_id`, `price`, `image_name`, `copies_available`, `active`) VALUES
(1, 'Dune', 'Frank Herbert', 'Set on the desert planet Arrakis, Dune is the story of the boy Paul Atreides, heir to a noble family tasked with ruling an inhospitable world where the only thing of value is the “spice” melange, a drug capable of extending life and enhancing consciousness. Coveted across the known universe, melange is a prize worth killing for....', 1, 250, 'book-Name-471.jpeg', 8, 'Yes'),
(2, 'A Man Called Ove', 'Fredrik Backman', 'The story revolves around Ove, a 59-year-old retiree who is bitter and isolated after the death of his wife, Sonja. Ove plans to commit suicide but his attempts are repeatedly failed by unexpected events and the kindness of his new neighbors,  who move in next door.  Ove gradually learns to embrace life again and finds new purpose.', 2, 350, 'book-Name-643.jpeg', 16, 'Yes'),
(3, 'The Hobbit', 'J.R.R Tolkien', 'The Hobbit is set in Middle-earth and follows Bilbo Baggins, the hobbit of the title, who joins the wizard Gandalf and the thirteen dwarves of Thorin\'s Company, on a quest to reclaim the dwarves\' home and treasure from the dragon Smaug. Bilbo\'s journey takes him from his peaceful rural surroundings into more sinister territory.', 4, 250, 'book-Name-700.jpeg', 3, 'Yes'),
(4, 'The Last Human', 'Zack Jordan', 'Most days, Sarya doesn\'t feel like the most terrifying creature in the galaxy. Most days, she\'s got other things on her mind. Like hiding her identity among the hundreds of alien species roaming the corridors of Watertower Station. Or making sure her adoptive mother doesn\'t casually eviscerate one of their neighbors. Again.', 1, 300, 'book-Name-537.jpeg', 3, 'Yes'),
(5, 'A River Enchanted', 'Rebecca Ross', 'set on a magical island called Cadence where music holds power, and a long-standing feud between families runs deep; the story follows Jack Tamerlaine, a bard summoned back to his homeland after young girls begin mysteriously disappearing, forcing him to work with his childhood enemy, Adaira, to unravel the mystery by using his music to , revealing a darker secret lurking beneath the surface.', 4, 399, 'book-Name-790.jpeg', 6, 'Yes'),
(6, 'Atomic Habits', 'James Clear', 'Atomic Habits by James Clear is a comprehensive, practical guide on how to change your habits and get 1% better every day. Using a framework called the Four Laws of Behavior Change, Atomic Habits teaches readers a simple set of rules for creating good habits and breaking bad ones. Learn how to build a habit in 4 simple steps.', 3, 450, 'book-Name-359.jpeg', 13, 'Yes'),
(7, 'Ikigai', 'Hector and Francesc', '\'Ikigai\' by Hector Garcia and Francesc Miralles explores the Japanese concept of finding one\'s purpose in life by analyzing the habits and beliefs of the world\'s longest-living people. Through case studies, the book offers practical insights on how to live a more fulfilling life.', 3, 299, 'book-Name-883.jpeg', 10, 'Yes'),
(8, 'Mr. Penumbra\'s 24-Hour Bookstore', 'Robin Sloan', 'Clay Jannon tells how serendipity, sheer curiosity, and the ability to climb a ladder like a monkey has sent him from Web Drone to night shift at Mr. Penumbra’s 24-Hour Bookstore. After just a few days on the job, Clay realizes just how curious this store is.A few customers come in repeatedly without buying anything. Instead they “check out” obscure volumes from strange corners of the store. ', 5, 399, 'book-Name-632.jpeg', 4, 'Yes'),
(9, 'You Are Fatally Invited', 'Ande Pliego', '\"You Are Fatally Invited\" is a thriller novel where a group of bestselling thriller writers are invited to a secluded island retreat hosted by a mysterious, anonymous author named J.R. Alastor, only to find themselves trapped in a deadly game when one of them is murdered, forcing them to navigate a twisted murder mystery where everyone is a suspect and the lines between fiction and reality blur.', 6, 399, 'book-Name-157.jpeg', 6, 'Yes'),
(11, 'The Kite Runner', 'Khaled Hosseini', '1970s Afghanistan: Twelve-year-old Amir is desperate to win the local kite-fighting tournament and his loyal friend Hassan promises to help him. But neither of the boys can foresee what would happen to Hassan that afternoon, an event that is to shatter their lives. After the Russians invade and the family is forced to flee to America, Amir realises that one day he must return to an Afghanistan under Taliban rule to find the one thing that his new world cannot grant him: redemption.', 2, 299, 'book-Name-107.jpeg', 8, 'Yes'),
(12, 'The Guide', 'Peter Heller', 'Jack who, is hired by an elite fishing lodge in Colorado, where amid the natural beauty of sun-drenched streams and forests he uncovers a plot of shocking menace.When he is assigned to guide a well-known singer, his only job is to rig her line, carry her gear, and steer her to the best trout he can find.\r\nBut then a human scream pierces the night, and Jack soon realizes that this idyllic fishing lodge may be merely a cover for a far more sinister operation.', 5, 299, 'book-Name-604.jpeg', 4, 'Yes'),
(13, 'The Mountain Is You', 'Brianna Wiest', 'This is a book about self-sabotage. Why we do it, when we do it, and how to stop doing it—for good. Coexisting but conflicting needs create self-sabotaging behaviors. This is why we resist efforts to change, often until they feel completely futile. But by extracting crucial insight from our most damaging habits, building emotional intelligence by better understanding our brains and bodies, releasing past experiences at a cellular level, and learning to act as our highest potential future selves, we can step out of our own way and into our potential. For centuries, the mountain has been used as a metaphor for the big challenges we face, especially ones that seem impossible to overcome.', 3, 289, 'book-Name-590.jpeg', 3, 'Yes'),
(14, 'This Is How You Heal', 'Brianna Wiest', 'Healing is not a one-time event.\r\n\r\nIt can begin with a one-time event — typically some form of sudden loss that disrupts our projection of what the future might be. However, the true work of healing is allowing that disruption to wake us from a deep state of unconsciousness, to release the personas we adapted into, and begin consciously piecing together the full truth of who we were meant to be.', 3, 299, 'book-Name-602.jpeg', 4, 'Yes'),
(15, 'The Exorcist', 'William Peter Blatty', 'William Peter Blatty created an iconic novel that focuses on Regan, the eleven-year-old daughter of a movie actress residing in Washington, D.C. A small group of overwhelmed yet determined individuals must rescue Regan from her unspeakable fate, and the drama that ensues is gripping and unfailingly terrifying. Two years after its publication, The Exorcist was, of course, turned into a wildly popular motion picture, garnering ten Academy Award nominations.', 7, 289, 'book-Name-201.jpeg', 7, 'Yes'),
(16, 'The Women In The Walls', 'Patrice Kindl\'s', 'Anna is more than shy. She is nearly invisible. At seven, terrified of school, Anna retreats within the walls of her family\'s enormous house, and builds a world of passageways and hidden rooms. As the years go by, people forget she ever existed. Then a mysterious note is thrust through a crack in the wall, and Anna must decide whether or not to come out of hiding. ', 7, 299, 'book-Name-522.jpeg', 3, 'Yes'),
(17, 'Something in the walls', 'Daisy Pearce', 'Mina Ellis is a newly graduated student with a degree in child physiology.Mina meets Sam, a journalist. Sam approaches Mina to help him out with a story of a teenage girl, Alice who is being possessed by a witch. Mina decided to help Sam. Sam and Mina are seeing and feeling strange things that they can’t explain. Now more than anything they must figure out what is really happening to Alice before it’s too late.', 6, 350, 'book-Name-616.jpeg', 5, 'Yes'),
(18, 'Python Programming', 'Sundarrajan & Deepak', 'Unlock the power of Python for engineering with our comprehensive guide. Designed specifically for engineers, this book bridges theory with practical application, empowering you to harness Python\'s versatility for complex problem-solving, data analysis, and automation tasks. From fundamentals to advanced techniques, dive into a hands-on journey that equips you with the skills needed to excel in your field. Whether you\'re a seasoned engineer or just starting, this book will be your go-to resource for mastering Python and revolutionizing your engineering approach.', 8, 299, 'book-Name-42.jpeg', 6, 'Yes'),
(19, 'Web Development', 'White Belt Mastery', 'This book provide guide on how to create web pages with HTML, how to format pages with CSS, how to customize website with javascript. This book is beginners centered which will help one learn basic concept for web development', 8, 349, 'book-Name-761.jpeg', 5, 'Yes'),
(20, 'Software Engineering', 'Roger & Bruce', 'This book covers the basic aspects of software engineering in details.\r\nSection clustering based on instructor’s requirement is available. Boxed features throughout the textbook included to present the trials and tribulations of a (fictional) software team and to provide supplementary materials about methods and tools that are relevant to chapter topics.', 8, 340, 'book-Name-198.jpeg', 5, 'Yes'),
(21, 'Into Thin Air', 'Jon Krakauer', 'The author describes his spring 1996 trek to Mt. Everest, a disastrous expedition that claimed the lives of eight climbers, and explains why he survived.By writing Into Thin Air, Krakauer may have hoped to exorcise some of his own demons and lay to rest some of the painful questions that still surround the event. He takes great pains to provide a balanced picture of the people and events he witnessed and gives due credit to the tireless and dedicated Sherpas. He also avoids blasting easy targets such as Sandy Pittman, the wealthy socialite who brought an espresso maker along on the expedition.', 5, 299, 'book-Name-317.jpeg', 4, 'Yes'),
(22, 'Station Eleven', 'Emily John', 'An audacious, darkly glittering novel set in the eerie days of civilization’s collapse—the spellbinding story of a Hollywood star, his would-be savior, and a nomadic group of actors roaming the scattered outposts of the Great Lakes region, risking everything for art and humanity.', 1, 250, 'book-Name-842.jpeg', 4, 'Yes'),
(23, 'The Silent Patient', 'Alex Michaelides', 'Alicia Berenson’s life is seemingly perfect. A famous painter married to an in-demand fashion photographer, she lives in a grand house with big windows overlooking a park in one of London’s most desirable areas. One evening her husband Gabriel returns home late from a fashion shoot, and Alicia shoots him five times in the face, and then never speaks another word.\r\n\r\nAlicia’s refusal to talk, or give any kind of explanation, turns a domestic tragedy into something far grander, a mystery that captures the public imagination and casts Alicia into notoriety. The price of her art skyrockets, and she, the silent patient, is hidden away from the tabloids and spotlight at the Grove, a secure forensic unit in North London.', 6, 299, 'book-Name-150.jpeg', 9, 'Yes'),
(24, 'A Thousand Splendid Suns', 'Khaled Hosseini', 'Mariam is only fifteen when she is sent to Kabul to marry the troubled and bitter Rasheed, who is thirty years her senior. Nearly two decades later, in a climate of growing unrest, tragedy strikes fifteen-year-old Laila, who must leave her home and join Mariam\'s unhappy household. Laila and Mariam are to find consolation in each other, their friendship to grow as deep as the bond between sisters, as strong as the ties between mother and daughter.\r\n\r\nWith the passing of time comes Taliban rule over Afghanistan, the streets of Kabul loud with the sound of gunfire and bombs, life a desperate struggle against starvation, brutality and fear, the women\'s endurance tested beyond their worst imaginings. Yet love can move people to act in unexpected ways, lead them to overcome the most daunting obstacles with a startling heroism. In the end it is love that triumphs over death and destruction.', 2, 350, 'book-Name-22.jpeg', 7, 'Yes'),
(25, 'The Women In The Walls', 'fff', 'ggg', 4, 450, 'book-Name-278.jpeg', 6, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_genre`
--

CREATE TABLE `tbl_genre` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_genre`
--

INSERT INTO `tbl_genre` (`id`, `title`, `active`) VALUES
(1, 'Sci-fi', 'Yes'),
(2, 'Fiction', 'Yes'),
(3, 'Non-Fiction', 'Yes'),
(4, 'Fantasy', 'Yes'),
(5, 'Adventure', 'Yes'),
(6, 'Mystery', 'Yes'),
(7, 'Horror', 'Yes'),
(8, 'Educational', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `orders` varchar(150) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `paid` varchar(10) NOT NULL,
  `order_date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `user_contact` varchar(20) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `user_id`, `orders`, `price`, `quantity`, `total`, `payment_mode`, `paid`, `order_date`, `status`, `user_name`, `user_contact`, `user_email`, `user_address`) VALUES
(3, 1, 'A Man Called Ove', '350', '2', 700.00, 'Online', 'Yes', '2025-02-25 19:23:48', 'Delivered', 'Nibah Kondvilkar', '8010909048', 'nibahkondvilkar@gmail.com', 'Dapoli'),
(5, 1, 'Dune', '150', '1', 150.00, 'COD', 'Yes', '2025-02-26 13:06:27', 'Delivered', 'Arshin Mukadam', '9156967865', 'nibahkondvilkar@gmail.com', 'Dapoli'),
(6, 2, 'A Man Called Ove,The Hobbit', '350,250', '1,1', 600.00, 'COD', 'No', '2025-02-27 14:15:33', 'Cancelled', 'Arshin Mukadam', '9156957865', 'Mukadamarshin@gmail.com', 'Kalam Gali'),
(7, 3, 'The Kite Runner,A River Enchanted', '299,399', '1,1', 698.00, 'Online', 'Yes', '2025-02-28 08:32:14', 'Delivered', 'Hibah Kondvilkar', '7756789033', 'hibahkondvilkar123@gmail.com', 'Nasheman colony,Dapoli'),
(8, 4, 'You Are Fatally Invited,The Kite Runner', '399,299', '1,1', 698.00, 'COD', 'Yes', '2025-02-28 10:55:48', 'Delivered', 'Aqsa Sarang', '9308958642', 'aqsafarid2772@gmail.com', 'Dapoli'),
(9, 1, 'A River Enchanted,Atomic Habits', '399,450', '1,1', 849.00, 'COD', 'Yes', '2025-03-08 11:04:52', 'Delivered', 'Nibah Kondvilkar', '8010909048', 'nibahkondvilkar@gmail.com', 'Dapoli'),
(10, 5, 'Web Development,The Women In The Walls', '349,299', '1,1', 648.00, 'Online', 'Yes', '2025-03-13 18:37:52', 'Delivered', 'Sultan Hussain', '9112970643', 'Sultanfdh22@gmail.com', 'Family Mal,Dapoli'),
(11, 5, 'A River Enchanted,The Last Human', '399,300', '1,1', 699.00, 'COD', 'Yes', '2025-03-16 19:24:49', 'Delivered', 'Praful Vadar', '7734198809', 'praful@gmail.com', 'Dapoli'),
(12, 5, 'The Guide,This Is How You Heal', '299,299', '1,1', 598.00, 'Online', 'Yes', '2025-03-20 19:40:22', 'Delivered', 'Uwes Kulabkar', '8997067890', 'uwes321@gmail.com', 'Dapoli'),
(13, 3, 'Mr. Penumbra\'s 24-Hour Bookstore,The Hobbit', '399,250', '1,1', 649.00, 'Online', 'Yes', '2025-03-23 13:44:51', 'Delivered', 'Hibah Kondvilkar', '7756789033', 'hibahkondvilkar123@gmail.com', 'Nasheman colony,Dapoli'),
(14, 3, 'You Are Fatally Invited,The Women In The Walls', '399,299', '1,1', 698.00, 'Online', 'Yes', '2025-03-26 13:55:14', 'Delivered', 'Zainab Ainarkar', '8860409877', 'zainab@gmail.com', 'Murud'),
(15, 2, 'The Mountain Is You', '289', '1', 289.00, 'COD', 'No', '2025-04-03 14:03:11', 'Cancelled', 'Arshin Mukadam', '9156957865', 'Mukadamarshin@gmail.com', 'Kalam Gali'),
(16, 2, 'A River Enchanted,The Silent Patient', '399,299', '1,1', 698.00, 'COD', 'Yes', '2025-04-06 14:13:19', 'Delivered', 'Zahin Mukadam', '7654320978', 'zahin12@gmail.com', 'Dapoli'),
(17, 6, 'A Man Called Ove', '350', '1', 350.00, 'COD', 'Yes', '2025-04-11 14:20:41', 'Delivered', 'Arshiya Kondvilkar', '9110080766', 'arshiyakondvilkar12@gmail.com', 'Dapoli'),
(18, 6, 'Dune,The Exorcist', '250,289', '1,1', 539.00, 'Online', 'Yes', '2025-04-11 14:24:54', 'Delivered', 'Rafiya Kondvilkar', '9545608096', 'rafiya@gmail.com', 'Dapoli'),
(19, 7, 'Into Thin Air', '299', '1', 299.00, 'Online', 'Yes', '2025-04-12 14:31:16', 'Delivered', 'Misbah Kazi', '9458908849', 'misbahk@gmail.com', 'Dapoli'),
(20, 7, 'Station Eleven,The Last Human', '250,300', '1,1', 550.00, 'Online', 'Yes', '2025-04-13 14:34:30', 'On Delivery', 'Rutuja Tambe', '9980786654', 'rutuja@gmail.com', 'Jalgoan'),
(21, 1, 'The Mountain Is You,A Thousand Splendid Suns', '289,350', '1,1', 639.00, 'Online', 'Yes', '2025-04-14 19:47:48', 'Pending', 'Nibah Kondvilkar', '8010909048', 'nibahkondvilkar@gmail.com', 'Dapoli'),
(22, 1, 'Atomic Habits', '450', '1', 450.00, 'COD', 'No', '2025-04-15 10:45:21', 'Pending', 'Nibah Kondvilkar', '8010909048', 'nibahkondvilkar@gmail.com', 'Dapoli');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id`, `full_name`, `contact`, `email`, `address`) VALUES
(1, 'Umera Sarang', '9949698909', 'umera@gmail.com', 'dapoli'),
(2, 'Aqsa ', '9156967867', 'aqsa@gmail.com', 'Dapoli'),
(3, 'Mitali Prajapat', '7734567809', 'mitaliprajapat@gmail.com', 'Dapoli'),
(4, 'Rinal Pandire', '9089967098', 'rinal@gmail.com', 'Jalgoan'),
(5, 'Diksha Nagvekar', '7889070566', 'diksha@gmail.com', 'Kolthare'),
(6, 'Shivia Nivarkar', '8079967789', 'shivia@gmail.om', 'Gimhavne'),
(7, 'Arshi Khan', '7889065433', 'arshikhan@gmail.com', 'Dapoli');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_books`
--

CREATE TABLE `tbl_supplier_books` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_mode` varchar(100) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_supplier_books`
--

INSERT INTO `tbl_supplier_books` (`id`, `supplier_id`, `book_title`, `quantity`, `order_date`, `payment_mode`, `payment_amount`) VALUES
(2, 1, 'Dune', 10, '2025-02-22 12:26:00', 'Cash', 2000.00),
(3, 2, 'A Man Called Ove', 20, '2025-02-25 13:30:11', 'Online', 6000.00),
(4, 3, 'The Hobbit', 5, '2025-02-28 13:05:16', 'COD', 1200.00),
(5, 4, 'The Last Human', 5, '2025-02-28 13:29:37', 'Online', 1400.00),
(6, 1, 'A River Enchanted', 10, '2025-02-28 13:35:39', 'Online', 2300.00),
(7, 2, 'Atomic Habits', 15, '2025-03-01 07:50:13', 'Online', 6200.00),
(8, 4, 'Ikigai', 10, '2025-03-01 07:53:35', 'COD', 2700.00),
(9, 3, 'Mr. Penumbra\'s 24-Hour Bookstore', 5, '2025-03-01 08:08:32', 'COD', 1700.00),
(10, 2, 'You Are Fatally Invited', 8, '2025-03-04 01:58:20', 'Online', 3100.00),
(11, 5, 'Something in the walls', 5, '2025-03-04 02:11:28', 'Online', 1600.00),
(12, 5, 'The Kite Runner', 10, '2025-03-04 02:21:26', 'COD', 2500.00),
(13, 4, 'The Guide', 5, '2025-03-04 02:33:36', 'COD', 1400.00),
(14, 6, 'The Mountain Is You', 5, '2025-04-11 14:05:31', 'Online', 1445.00),
(15, 5, 'This Is How You Heal', 5, '2025-04-11 14:07:09', 'Online', 1550.00),
(16, 6, 'The Exorcist', 8, '2025-04-11 14:22:40', 'Online', 3100.00),
(17, 4, 'The Women In The Walls', 5, '2025-04-11 14:24:03', 'Online', 1480.00),
(18, 7, 'Web Development', 6, '2025-04-13 12:44:31', 'Online', 2000.00),
(19, 7, 'Python Programming', 6, '2025-04-13 12:46:32', 'Online', 2050.00),
(20, 4, 'Software Engineering', 5, '2025-04-13 12:50:37', 'Online', 1990.00),
(21, 2, 'Into Thin Air', 5, '2025-04-13 14:44:27', 'Online', 1480.00),
(22, 3, 'Station Eleven', 5, '2025-04-13 14:46:25', 'Online', 1240.00),
(23, 7, 'The Silent Patient', 10, '2025-04-14 08:41:04', 'Online', 2950.00),
(24, 6, 'A Thousand Splendid Suns', 8, '2025-04-14 14:15:06', 'Online', 2550.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL,
  `otp_expiry` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `full_name`, `username`, `contact`, `email`, `address`, `password`, `otp`, `otp_expiry`, `created_at`) VALUES
(1, 'Nibah Kondvilkar', 'nibah', '8010909048', 'nibahkondvilkar@gmail.com', 'Dapoli', 'f2191f9974f86242703de889c50651cb', 0, '0000-00-00 00:00:00', '2025-02-23 17:26:52'),
(2, 'Arshin Mukadam', 'arshin', '9156957865', 'Mukadamarshin@gmail.com', 'Kalam Gali', 'f8d3c6d2aeb6e37c5b2e11b4ffbeec69', 0, '0000-00-00 00:00:00', '2025-02-24 13:13:18'),
(3, 'Hibah Kondvilkar', 'hibah', '7756789033', 'hibahkondvilkar123@gmail.com', 'Nasheman colony,Dapoli', 'fd7684808fc2e4f451b55d28fd493df5', 0, '0000-00-00 00:00:00', '2025-03-25 07:18:32'),
(4, 'Aqsa Sarang', 'aqsa', '9308958642', 'aqsafarid2772@gmail.com', 'Dapoli', '30417b5ea40131eed91095d90b5d270b', 0, '0000-00-00 00:00:00', '2025-03-26 09:22:06'),
(5, 'Sultan Hussain', 'sultan', '9112970643', 'Sultanfdh22@gmail.com', 'Family Mal,Dapoli', 'f08bcef10dd00fef60e0e687f5aa5e59', 0, '0000-00-00 00:00:00', '2025-03-13 16:35:11'),
(6, 'Arshiya Kondvilkar', 'arshiya', '9110080766', 'arshiyakondvilkar12@gmail.com', 'Dapoli', '2d1a19030d8f492851ca81d388365246', 0, '0000-00-00 00:00:00', '2025-04-08 17:59:37'),
(7, 'Misbah Kazi', 'misbah', '9458908849', 'misbahk@gmail.com', 'Dapoli', '7dba53dfa4e24db05e61639461cf7c91', 0, '0000-00-00 00:00:00', '2025-04-12 12:27:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_genre`
--
ALTER TABLE `tbl_genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier_books`
--
ALTER TABLE `tbl_supplier_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_genre`
--
ALTER TABLE `tbl_genre`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_supplier_books`
--
ALTER TABLE `tbl_supplier_books`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_supplier_books`
--
ALTER TABLE `tbl_supplier_books`
  ADD CONSTRAINT `tbl_supplier_books_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `tbl_supplier` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
