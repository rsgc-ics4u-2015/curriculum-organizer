-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: ct
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `author_or_editor`
--

DROP TABLE IF EXISTS `author_or_editor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author_or_editor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author_or_editor`
--

LOCK TABLES `author_or_editor` WRITE;
/*!40000 ALTER TABLE `author_or_editor` DISABLE KEYS */;
INSERT INTO `author_or_editor` VALUES (1,'rgordon','Russell','Gordon','$2y$10$6YEfxymb/BmAO6rHcl0/tOlkeor5DAQj6ZU8MDIFohTQkCXoGQ3GW',0),(2,'rgordon-test','Russell','Gordon','$2y$10$yOwJwIfOeJd2te78IhiFLOU981Ve78IQQ9yyeQhL5dm4FdHXIPrkS',0),(3,'hello','Hello','There','$2y$10$eJvqY8MqqpK4EhFoF/ZAhOvO4R19ml1wxlNV4YWqFIvXIx5L3vmIC',0);
/*!40000 ALTER TABLE `author_or_editor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citation_or_source`
--

DROP TABLE IF EXISTS `citation_or_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `citation_or_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(1000) NOT NULL,
  `shortname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citation_or_source`
--

LOCK TABLES `citation_or_source` WRITE;
/*!40000 ALTER TABLE `citation_or_source` DISABLE KEYS */;
/*!40000 ALTER TABLE `citation_or_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `code` varchar(8) NOT NULL,
  `url` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Principles of Mathematics, Grade 9, Academic','This course enables students to develop an understanding of mathematical concepts related to algebra, analytic geometry, and measurement and geometry through investigation, the effective use of technology, and abstract reasoning. Students will investigate relationships, which they will then generalize as equations of lines, and will determine the connections between different representations of a linear relation. They will also explore relationships that emerge from the measurement of three-dimensional figures and two-dimensional shapes. Students will reason mathematically and communicate their thinking as they solve multi-step problems.','MPM1D','http://www.edu.gov.on.ca/eng/curriculum/secondary/math910curr.txt'),(2,'Principles of Mathematics, Grade 10, Academic','This course enables students to broaden their understanding of relationships and extend their problem-solving and algebraic skills through investigation, the effective use of technology, and abstract reasoning. Students will explore quadratic relations and their applications; solve and apply linear systems; verify properties of geometric figures using analytic geometry; and investigate the trigonometry of right and acute triangles. Students will reason mathematically and communicate their thinking as they solve multi-step problems.','MPM2D','http://www.edu.gov.on.ca/eng/curriculum/secondary/math910curr.txt');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_category`
--

DROP TABLE IF EXISTS `evaluation_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evaluation_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_category`
--

LOCK TABLES `evaluation_category` WRITE;
/*!40000 ALTER TABLE `evaluation_category` DISABLE KEYS */;
INSERT INTO `evaluation_category` VALUES (1,'Knowledge'),(2,'Inquiry'),(3,'Communication'),(4,'Application');
/*!40000 ALTER TABLE `evaluation_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `minor_expectation`
--

DROP TABLE IF EXISTS `minor_expectation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `minor_expectation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `overall_expectation_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`overall_expectation_id`),
  KEY `fk_minor_expectation_overall_expectation1_idx` (`overall_expectation_id`),
  CONSTRAINT `fk_minor_expectation_overall_expectation1` FOREIGN KEY (`overall_expectation_id`) REFERENCES `overall_expectation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `minor_expectation`
--

LOCK TABLES `minor_expectation` WRITE;
/*!40000 ALTER TABLE `minor_expectation` DISABLE KEYS */;
INSERT INTO `minor_expectation` VALUES (1,'1','substitute into and evaluate algebraic expressions involving exponents\r\n(i.e., evaluate expressions involving natural-number exponents with rational-number bases [e.g., evaluate (3/2)^2 by hand and 9.8^3 using a calculator])\r\n(Sample problem: A movie theatre wants to compare the volumes of popcorn in two containers, a cube with edge length 8.1 cm and a cylinder with radius 4.5 cm and height 8.0 cm. Which container holds more popcorn?)',1),(2,'2','describe the relationship between the algebraic and geometric representations of a single-variable term up to degree three\r\n[i.e., length, which is one dimensional, can be represented by x; area, which is two dimensional, can be represented by (x)(x) or x2; volume, which is three dimensional, can be represented by (x)(x)(x), (x2)(x), or x3]',1),(3,'3','derive, through the investigation and examination of patterns, the exponent rules for multiplying and dividing monomials, and apply these rules in expressions involving one and two variables with positive exponents',1),(4,'4','extend the multiplication rule to derive and understand the power of a power rule, and apply it to simplify expressions involving one and two variables with positive exponents',1),(5,'1','simplify numerical expressions involving integers and rational numbers, with and without the use of technology',2),(6,'2','solve problems requiring the manipulation of expressions arising from applications of percent, ratio, rate, and proportion',2),(7,'3','relate their understanding of inverse operations to squaring and taking the square root, and apply inverse operations to simplify expressions and solve equations',2),(8,'4','add and subtract polynomials with up to two variables\r\n[e.g., (2x â€“ 5) + (3x + 1), (3x2y + 2xy2) + (4x2y â€“ 6xy2)], using a variety of tools (e.g., algebra tiles, computer algebra systems, paper and pencil)',2),(9,'5','multiply a polynomial by a monomial involving the same variable\r\n[e.g., 2x(x + 4), 2x2(3x2 â€“ 2x + 1)], using a variety of tools (e.g., algebra tiles, diagrams, computer algebra systems, paper and pencil)',2),(10,'6','expand and simplify polynomial expressions involving one variable [e.g., 2x(4x + 1) â€“ 3x(x + 2)], using a variety of tools (e.g., algebra tiles, computer algebra systems, paper and pencil);',2),(11,'8','rearrange formulas involving variables in the first degree, with and without substitution (e.g., in analytic geometry, in measurement) (Sample problem: A circular garden has a circumference of 30 m. What is the length of a straight path that goes through the centre of this garden?)',2),(12,'9','solve problems that can be modelled with first-degree equations, and compare algebraic methods to other solution methods (Sample problem: Solve the following problem in more than one way: Jonah is involved in a walkathon. His goal is to walk 25 km. He begins at 9:00 a.m. and walks at a steady rate of 4 km/h. How many kilometres does he still have left to walk at 1:15 p.m. if he is to achieve his goal?)',2),(13,'1','interpret the meanings of points on scatter plots or graphs that represent linear relations, including scatter plots or graphs in more than one quadrant [e.g., on a scatter plot of height versus age, interpret the point (13, 150) as representing a student who is 13 years old and 150 cm tall; identify points on the graph that represent students who are taller and younger than this student] (Sample problem: Given a graph that represents the relationship of the Celsius scale and the Fahrenheit scale, determine the Celsius equivalent of â€“5Â°F.)',3),(14,'2','pose problems, identify variables, and formulate hypotheses associated with relationships between two variables (Sample problem: Does the rebound height of a ball depend on the height from which it was dropped?)',3),(15,'3','design and carry out an investigation or experiment involving relationships between two variables, including the collection and organization of data, using appropriate methods, equipment, and/or technology (e.g., surveying; using measuring tools, scientific probes, the Internet) and techniques (e.g.,making tables, drawing graphs) (Sample problem: Design and perform an experiment to measure and record the temperature of ice water in a plastic cup and ice water in a thermal mug over a 30 min period, for the purpose of comparison. What factors might affect the outcome of this experiment? How could you design the experiment to account for them?)',3),(16,'4','describe trends and relationships observed in data, make inferences from data, compare the inferences with hypotheses about the data, and explain any differences between the inferences and the hypotheses (e.g., describe the trend observed in the data. Does a relationship seem to exist? Of what sort? Is the outcome consistent with your hypothesis? Identify and explain any outlying pieces of data. Suggest a formula that relates the variables. How might you vary this experiment to examine other relationships?) (Sample problem: Hypothesize the effect of the length of a pendulum on the time required for the pendulum to make five full swings. Use data to make an inference. Compare the inference with the hypothesis. Are there other relationships you might investigate involving pendulums?)',3),(17,'1','construct tables of values, graphs, and equations, using a variety of tools (e.g., graphing calculators, spreadsheets, graphing software, paper and pencil), to represent linear relations derived from descriptions of realistic situations (Sample problem: Construct a table of values, a graph, and\r\nan equation to represent a monthly cellphone plan that costs $25, plus $0.10 per minute of airtime.)',4),(18,'2','construct tables of values, scatter plots, and lines or curves of best fit as appropriate, using a variety of tools (e.g., spreadsheets, graphing software, graphing calculators, paper and pencil), for linearly related and non-linearly related data collected from a variety of sources (e.g., experiments, electronic secondary sources, patterning with concrete materials) (Sample problem: Collect data, using concrete materials or dynamic geometry software, and construct a table of values, a scatter plot, and a line or curve of best fit to represent the following relationships: the volume and the height for a square-based prism with a fixed base; the volume and the side length of the base for a square-based prism with a fixed height.)',4),(19,'3','identify, through investigation, some properties of linear relations (i.e., numerically, the first difference is a constant, which represents a constant rate of change; graphically, a straight line represents the relation), and apply these properties to determine whether a relation is linear or non-linear',4),(20,'5','determine the equation of a line of best fit for a scatter plot, using an informal process (e.g., using a movable line in dynamic statistical software; using a process of trial and error on a graphing calculator; determining the equation of the line joining two carefully chosen points on the scatter plot)',4),(21,'1','determine values of a linear relation by using a table of values, by using the equation of the relation, and by interpolating or extrapolating from the graph of the relation (Sample problem: The equation H = 300 â€“ 60t represents the height of a hot air balloon that is initially at 300 m and is descending at a constant rate of 60 m/min. Determine algebraically and graphically how long the balloon will take to reach a height of 160 m.)',5),(22,'2','describe a situation that would explain the events illustrated by a given graph of a relationship between two variables (Sample problem: The walk of an individual is illustrated in the given graph, produced by a motion detector and a graphing calculator. Describe the walk [e.g., the initial distance from the motion detector, the rate of walk].)',5),(23,'3','determine other representations of a linear relation, given one representation (e.g., given a numeric model, determine a graphical model and an algebraic model; given a graph, determine some points on the graph and determine an algebraic model)',5),(24,'4','describe the effects on a linear graph and make the corresponding changes to the linear equation when the conditions of the situation they represent are varied (e.g., given a partial variation graph and an equation representing the cost of producing a yearbook, describe how the graph changes if the cost per book is altered, describe how the graph changes if the fixed costs are altered, and make the corresponding changes to the equation)',5),(25,'1','determine, through investigation, the characteristics that distinguish the equation of a straight line from the equations of nonlinear relations (e.g., use a graphing calculator or graphing software to graph a variety of linear and non-linear relations from their equations; classify the relations according to the shapes of their graphs; connect an equation of degree one to a linear relation)',6),(26,'2','identify, through investigation, the equation of a line in any of the forms y = mx + b, Ax + By + C = 0, x = a, y = b',6),(27,'3','express the equation of a line in the form y = mx + b, given the form Ax + By + C = 0',6),(28,'1','determine, through investigation, various formulas for the slope of a line segment or a line (e.g., m = rise / run, m = (the change in y) / (the change in x) or m = (delta y) / (delta x), m = (y2 - y1) / (x2 - x1), and use the formulas to determine the slope of a line segment or a line',7),(29,'2','identify, through investigation with technology, the geometric significance of m and b in the equation y = mx + b',7),(30,'3','determine, through investigation, connections among the representations of a constant rate of change of a linear relation (e.g., the cost of producing a book of photographs is $50, plus $5 per book, so an equation is C = 50 + 5p; a table of values provides the first difference of 5; the rate\r\nof change has a value of 5, which is also the slope of the corresponding line; and 5 is the coefficient of the independent variable, p, in this equation)',7),(31,'4','identify, through investigation, properties of the slopes of lines and line segments (e.g., direction, positive or negative rate of change, steepness, parallelism, perpendicularity), using graphing technology to facilitate investigations, where appropriate',7),(32,'1','graph lines by hand, using a variety of techniques (e.g., graph y=2/3x - 4 using the y-intercept and slope; graph 2x + 3y = 6 using the x- and y-intercepts);',8),(33,'2','determine the equation of a line from information about the line (e.g., the slope and y-intercept; the slope and a point; two points) (Sample problem: Compare the equations of the lines parallel to and perpendicular to y = 2x â€“ 4, and with the same x-intercept as 3x â€“ 4y = 12. Verify using dynamic geometry software.)',8),(34,'3','describe the meaning of the slope and y-intercept for a linear relation arising from a realistic situation (e.g., the cost to rent the community gym is $40 per evening, plus $2 per person for equipment rental; the vertical intercept, 40, represents the $40 cost of renting the gym; the value of the rate of change, 2, represents the $2 cost per person), and describe a situation that could be modelled by a given linear equation (e.g., the linear equation M = 50 + 6d could model the mass of a shipping package, including 50 g for the packaging material, plus 6 g per flyer added to the package)',8),(35,'4','identify and explain any restrictions on the variables in a linear relation arising from a realistic situation (e.g., in the relation C = 50 + 25n,C is the cost of holding a party in a hall and n is the number of guests; n is restricted to whole numbers of 100 or less, because of the size of the\r\nhall, and C is consequently restricted to $50 to $2550)',8),(36,'5','determine graphically the point of intersection of two linear relations, and interpret the intersection point in the context of an application (Sample problem: A video rental company has two monthly plans. Plan A charges a flat fee of $30 for unlimited rentals; Plan B charges $9, plus $3 per video. Use a graphical model to determine the conditions under which you should choose Plan A or Plan B.)',8),(37,'1','determine the maximum area of a rectangle with a given perimeter by constructing a variety of rectangles, using a variety of tools (e.g., geoboards, graph paper, toothpicks, a pre-made dynamic geometry sketch), and by examining various values of the area as the side lengths change and the perimeter remains constant',9),(38,'2','determine the minimum perimeter of a rectangle with a given area by constructing a variety of rectangles, using a variety of tools (e.g., geoboards, graph paper, a premade dynamic geometry sketch), and by examining various values of the side lengths and the perimeter as the area stays constant',9),(39,'3','identify, through investigation with a variety of tools (e.g. concrete materials, computer software), the effect of varying the dimensions on the surface area [or volume] of square-based prisms and cylinders, given a fixed volume [or surface area]',9),(40,'4','explain the significance of optimal area, surface area, or volume in various applications (e.g., the minimum amount of packaging material; the relationship between surface area and heat loss)',9),(41,'5','pose and solve problems involving maximization and minimization of measurements of geometric shapes and figures (e.g., determine the dimensions of the rectangular field with the maximum area that can be enclosed by a fixed amount of fencing, if the fencing is required on only three sides) (Sample problem: Determine the dimensions of a square-based, opentopped prism with a volume of 24 cm3 and with the minimum surface area.)',9),(42,'1','relate the geometric representation of the Pythagorean theorem and the algebraic representation a2 + b2 = c2',10),(43,'2','solve problems using the Pythagorean theorem, as required in applications (e.g., calculate the height of a cone, given the radius and the slant height, in order to determine the volume of the cone);',10),(44,'3','solve problems involving the areas and perimeters of composite two-dimensional shapes (i.e., combinations of rectangles, triangles, parallelograms, trapezoids, and circles) (Sample problem: A new park is in the shape of an isosceles trapezoid with a square attached to the shortest side. The side lengths of the trapezoidal section are 200 m, 500 m, 500 m, and 800 m, and the side length of the square section is 200 m. If the park is to be fully fenced and sodded, how much fencing and sod are required?)',10),(45,'4','develop, through investigation (e.g., using concrete materials), the formulas for the volume of a pyramid, a cone, and a sphere',10),(46,'5','determine, through investigation, the relationship for calculating the surface area of a pyramid (e.g., use the net of a squarebased pyramid to determine that the surface area is the area of the square base plus the areas of the four congruent triangles)',10),(47,'6','solve problems involving the surface areas and volumes of prisms, pyramids, cylinders, cones, and spheres, including composite figures (Sample problem: Break-bit Cereal is sold in a single-serving size, in a box in the shape of a rectangular prism of dimensions 5 cm by 4 cm by 10 cm. The manufacturer also sells the cereal in a larger size, in a box with dimensions double those of the smaller box. Compare the surface areas and the volumes of the two boxes, and explain the implications of your answers.)',10),(48,'1','determine, through investigation using a variety of tools (e.g., dynamic geometry software, concrete materials), and describe the properties and relationships of the interior and exterior angles of triangles, quadrilaterals, and other polygons, and apply the results to problems involving the\r\nangles of polygons (Sample problem: With the assistance of dynamic geometry software, determine the relationship between the sum of the interior angles of a polygon and the number of sides. Use your conclusion to determine the sum of the interior angles of a 20-sided polygon.)',11),(49,'2','determine, through investigation using a variety of tools (e.g., dynamic geometry software, paper folding), and describe some properties of polygons (e.g., the figure that results from joining the midpoints of the sides of a quadrilateral is a parallelogram; the diagonals of a rectangle bisect each other; the line segment joining the midpoints of two sides of a triangle is half the length of the third side), and apply the results in problem solving (e.g., given the width of the base of an A-frame tree house, determine the length of a horizontal support beam that is attached half way up the sloping sides)',11),(50,'3','pose questions about geometric relationships, investigate them, and present their findings, using a variety of mathematical forms (e.g., written explanations, diagrams, dynamic sketches, formulas, tables) (Sample problem: How many diagonals can be drawn from one vertex of a 20-sided polygon? How can I find out without counting them?)',11),(51,'4','illustrate a statement about a geometric property by demonstrating the statement with multiple examples, or deny the statement on the basis of a counter-example, with or without the use of dynamic geometry software (Sample problem: Confirm or deny the following statement: If a quadrilateral has perpendicular diagonals, then it is a square.)',11),(52,'7','solve first-degree equations, including equations with fractional coefficients, using a variety of tools (e.g., computer algebra systems, paper and pencil) and strategies (e.g., the balance analogy, algebraic strategies)',2),(53,'4','compare the properties of direct variation and partial variation in applications, and identify the initial value (e.g., for a relation described in words, or represented as a graph or an equation) (Sample problem: Yoga costs $20 for registration, plus $8 per class.Tai chi costs $12 per class. Which situation represents a direct variation, and which represents a partial variation? For each relation, what is the initial value? Explain your answers.)',4),(54,'1','collect data that can be represented as a quadratic relation, from experiments using appropriate equipment and technology (e.g., concrete materials, scientific probes, graphing calculators), or from secondary sources (e.g., the Internet, Statistics Canada); graph the data and draw a curve of best fit, if appropriate, with or without the use of technology (Sample problem: Make a 1 m ramp that makes a 15Â° angle with the floor. Place a can 30 cm up the ramp. Record the time it takes for the can to roll to the bottom. Repeat by placing the can 40 cm, 50 cm, and 60 cm up the ramp, and so on. Graph the data and draw the curve of best fit.)',12),(55,'2','determine, through investigation with and without the use of technology, that a quadratic relation of the form y = ax2 + bx + c (a â‰  0) can be graphically represented as a parabola, and that the table of values yields a constant second difference (Sample problem: Graph the relation y = x2 â€“ 4x by developing a table of values and plotting points. Observe the shape of the graph. Calculate first and second differences. Repeat for different quadratic relations. Describe your observations and make conclusions, using the appropriate terminology.)',12),(56,'3','identify the key features of a graph of a parabola (i.e., the equation of the axis of symmetry, the coordinates of the vertex, the y-intercept, the zeros, and the maximum or minimum value), and use the appropriate terminology to describe them',12),(57,'4','compare, through investigation using technology, the features of the graph of y = x2 and the graph of y = 2x, and determine the meaning of a negative exponent and of zero as an exponent (e.g., by examining patterns in a table of values for y = 2x; by applying the exponent rules for multiplication\r\nand division)',12),(58,'1','identify, through investigation using technology, the effect on the graph of y = x2 of transformations (i.e., translations, reflections in the x-axis, vertical stretches or compressions) by considering separately each parameter a, h, and k [i.e., investigate the effect on the graph of y = x2 of a, h, and k in y = x2 + k, y = (x â€“ h)2, and y = ax2]',13),(59,'2','explain the roles of a, h, and k in y = a(x â€“ h )2 + k, using the appropriate terminology to describe the transformations, and identify the vertex and the equation of the axis of symmetry',13),(60,'3','sketch, by hand, the graph of y = a(x â€“ h )2 + k by applying transformations to the graph of y = x2',13),(61,'4','determine the equation, in the form y = a(x â€“ h)2 + k, of a given graph of a parabola',13),(62,'1','expand and simplify second-degree polynomial expressions [e.g., (2x + 5)2, (2x â€“ y)(x + 3y)], using a variety of tools (e.g., algebra tiles, diagrams, computer algebra systems, paper and pencil) and strategies (e.g., patterning)',14),(63,'2','factor polynomial expressions involving common factors, trinomials, and differences of squares [e.g., 2x2 + 4x, 2x â€“ 2y + ax â€“ ay, x2 â€“ x â€“ 6, 2a2 + 11a + 5, 4x2 â€“ 25], using a variety of tools (e.g., concrete materials, computer algebra systems, paper and pencil) and strategies (e.g., patterning)',14),(64,'3','determine, through investigation, and describe the connection between the factors of a quadratic expression and the x-intercepts (i.e., the zeros) of the graph of the corresponding quadratic relation, expressed in the form y = a(x â€“ r)(x â€“ s)',14),(65,'4','interpret real and non-real roots of quadratic equations, through investigation using graphing technology, and relate the roots to the x-intercepts of the corresponding relations',14),(66,'5','express y = ax2 + bx + c in the form y = a(x â€“ h)2 + k by completing the square in situations involving no fractions, using a variety of tools (e.g. concrete materials, diagrams, paper and pencil)',14),(67,'6','sketch or graph a quadratic relation whose equation is given in the form y = ax2 + bx + c, using a variety of methods (e.g., sketching y = x2 â€“ 2x â€“ 8 using intercepts and symmetry; sketching y = 3x2 â€“ 12x + 1 by completing the square and applying transformations; graphing h = â€“4.9t2 + 50t + 1.5 using technology)',14),(68,'7','explore the algebraic development of the quadratic formula (e.g., given the algebraic development, connect the steps to a numerical example; follow a demonstration of the algebraic development [student reproduction of the development of the general case is not required])',14),(69,'8','solve quadratic equations that have real roots, using a variety of methods (i.e., factoring, using the quadratic formula, graphing) (Sample problem: Solve x2 + 10x + 16 = 0 by factoring, and verify algebraically. Solve x2 + x â€“ 4 = 0 using the quadratic formula, and verify graphically using technology. Solve â€“4.9t2 + 50t + 1.5 = 0 by graphing h = â€“4.9t2 + 50t + 1.5 using technology.)',14),(70,'1','determine the zeros and the maximum or minimum value of a quadratic relation from its graph (i.e., using graphing calculators or graphing software) or from its defining equation (i.e., by applying algebraic techniques)',15),(71,'2','solve problems arising from a realistic situation represented by a graph or an equation of a quadratic relation, with and without the use of technology (e.g., given the graph or the equation of a quadratic relation representing the height of a ball over elapsed time, answer questions such as the following: What is the maximum height of the ball? After what length of time will the ball hit the ground? Over what time interval is the height of the ball greater than 3 m?)',15),(72,'1','solve systems of two linear equations involving two variables, using the algebraic method of substitution or elimination',16),(73,'2','solve problems that arise from realistic situations described in words or represented by linear systems of two equations involving two variables, by choosing an appropriate algebraic or graphical method (Sample problem: The Robotics Club raised $5000 to build a robot for a future competition. The club invested part of the money in an account that paid 4% annual interest, and the rest in a government bond that paid 3.5% simple interest per year. After one year, the club earned a total of $190 in interest. How much was invested at each rate? Verify your result.',16),(74,'1','develop the formula for the midpoint of a line segment, and use this formula to solve problems (e.g., determine the coordinates of the midpoints of the sides of a triangle, given the coordinates of the vertices, and verify concretely or by using dynamic geometry software)',17),(75,'2','develop the formula for the length of a line segment, and use this formula to solve problems (e.g., determine the lengths of the line segments joining the midpoints of the sides of a triangle, given the coordinates of the vertices of the triangle, and verify using dynamic geometry software)',17),(76,'3','develop the equation for a circle with centre (0, 0) and radius r, by applying the formula for the length of a line segment',17),(77,'4','determine the radius of a circle with centre (0, 0), given its equation; write the equation of a circle with centre (0, 0), given the radius; and sketch the circle, given the equation in the form x2 + y2 = r2',17),(78,'5','solve problems involving the slope, length, and midpoint of a line segment (e.g., determine the equation of the right bisector of a line segment, given the coordinates of the endpoints; determine the distance from a given point to a line whose equation is given, and verify using dynamic\r\ngeometry software)',17),(79,'1','determine, through investigation (e.g., using dynamic geometry software, by paper folding), some characteristics and properties of geometric figures (e.g., medians in a triangle, similar figures constructed on the sides of a right triangle)',18),(80,'2','verify, using algebraic techniques and analytic geometry, some characteristics of geometric figures (e.g., verify that two lines are perpendicular, given the coordinates of two points on each line; verify, by determining side length, that a triangle is equilateral, given the coordinates of the vertices)',18),(81,'3','plan and implement a multi-step strategy that uses analytic geometry and algebraic techniques to verify a geometric property (e.g., given the coordinates of the vertices of a triangle, verify that the line segment joining the midpoints of two sides of the triangle is parallel to the third side and half its length, and check using dynamic geometry software; given the coordinates of the vertices of a rectangle, verify that the diagonals of the rectangle bisect each other)',18),(82,'1','verify, through investigation (e.g., using dynamic geometry software, concrete materials), the properties of similar triangles (e.g., given similar triangles, verify the equality of corresponding angles and the proportionality of corresponding sides)',19),(83,'2','describe and compare the concepts of similarity and congruence',19),(84,'3','solve problems involving similar triangles in realistic situations (e.g., shadows, reflections, scale models, surveying) (Sample problem: Use a metre stick to determine the height of a tree, by means of the similar triangles formed by the tree, the metre stick, and their shadows.)',19),(85,'1','determine, through investigation (e.g., using dynamic geometry software, concrete materials), the relationship between the ratio of two sides in a right triangle and the ratio of the two corresponding sides in a similar right triangle, and define the sine, cosine, and tangent ratios (e.g., sin A = opposite / hypotenuse )',20),(86,'2','determine the measures of the sides and angles in right triangles, using the primary trigonometric ratios and the Pythagorean theorem',20),(87,'3','solve problems involving the measures of sides and angles in right triangles in reallife applications (e.g., in surveying, in navigating, in determining the height of an inaccessible object around the school), using the primary trigonometric ratios and the Pythagorean theorem',20),(88,'1','explore the development of the sine law within acute triangles (e.g., use dynamic geometry software to determine that the ratio of the side lengths equals the ratio of the sines of the opposite angles; follow the algebraic development of the sine law and identify the application of solving systems of equations [student reproduction of the development of the formula is not required])',21),(90,'2','explore the development of the cosine law within acute triangles (e.g., use dynamic geometry software to verify the cosine law; follow the algebraic development of the cosine law and identify its relationship to the Pythagorean theorem and the cosine ratio [student reproduction of the development of the formula is not required])',21),(91,'3','determine the measures of sides and angles in acute triangles, using the sine law and the cosine law',21),(92,'4','solve problems involving the measures of sides and angles in acute triangles',21);
/*!40000 ALTER TABLE `minor_expectation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `overall_expectation`
--

DROP TABLE IF EXISTS `overall_expectation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overall_expectation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `strand_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`strand_id`),
  KEY `fk_overall_expectation_strand1_idx` (`strand_id`),
  CONSTRAINT `fk_overall_expectation_strand1` FOREIGN KEY (`strand_id`) REFERENCES `strand` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `overall_expectation`
--

LOCK TABLES `overall_expectation` WRITE;
/*!40000 ALTER TABLE `overall_expectation` DISABLE KEYS */;
INSERT INTO `overall_expectation` VALUES (1,'1','Operating with Exponents','demonstrate an understanding of the exponent rules of multiplication and division, and apply them to simplify expressions',1),(2,'2','Manipulating Expressions and Solving Equations','manipulate numerical and polynomial expressions, and solve first-degree equations',1),(3,'1','Using Data Management to Investigate Relationships','apply data-management techniques to investigate relationships between two variables',2),(4,'2','Understanding Characteristics of Linear Relations','demonstrate an understanding of the characteristics of a linear relation',2),(5,'3','Connecting Various Representations of Linear Relations','connect various representations of a linear relation',2),(6,'1','Investigating the Relationship Between the Equation of a Relation and the Shape of Its Graph','determine the relationship between the form of an equation and the shape of its graph with respect to linearity and non-linearity',3),(7,'2','Investigating the Properties of Slope','determine, through investigation, the properties of the slope and y-intercept of a linear relation',3),(8,'3','Using the Properties of Linear Relations to Solve Problems','solve problems involving linear relations',3),(9,'1','Investigating the Optimal Values of Measurements','determine, through investigation, the optimal values of various measurements',4),(10,'2','Solving Problems Involving Perimeter, Area, Surface Area, and Volume','solve problems involving the measurements of two-dimensional shapes and the surface areas and volumes of three-dimensional figures',4),(11,'3','Investigating and Applying Geometric Relationships','verify, through investigation facilitated by dynamic geometry software, geometric properties and relationships involving two-dimensional shapes, and apply the results to solving problems',4),(12,'1','Investigating the Basic Properties of Quadratic Relations','determine the basic properties of quadratic relations',5),(13,'2','Relating the Graph of y=x2 and Its Transformations','relate transformations of the graph of y = x2 to the algebraic representation y = a(x â€“ h)2 + k',5),(14,'3','Solving Quadratic Equations','solve quadratic equations and interpret the solutions with respect to the corresponding relations',5),(15,'4','Solving Problems Involving Quadratic Relations','solve problems involving quadratic relations',5),(16,'1','Using Linear Systems to Solve Problems','model and solve problems involving the intersection of two straight lines',6),(17,'2','Solving Problems Involving Properties of Line Segments','solve problems using analytic geometry involving properties of lines and line segments',6),(18,'3','Using Analytic Geometry to Verify Geometric Properties','verify geometric properties of triangles and quadrilaterals, using analytic geometry',6),(19,'1','Investigating Similarity and Solving Problems Involving Similar Triangles','use their knowledge of ratio and proportion to investigate similar triangles and solve problems related to similarity',7),(20,'2','Solving Problems Involving the Trigonometry of Right Triangles','solve problems involving right triangles, using the primary trigonometric ratios and the Pythagorean theorem',7),(21,'3','Solving Problems Involving the Trigonometry of Acute Triangles','solve problems involving acute triangles, using the sine law and the cosine law',7);
/*!40000 ALTER TABLE `overall_expectation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortlabel` varchar(10) NOT NULL,
  `title` varchar(45) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `type_id` int(11) NOT NULL,
  `evaluation_category_id` int(11) NOT NULL,
  `author_or_editor_id` int(11) NOT NULL,
  `year` varchar(7) NOT NULL,
  PRIMARY KEY (`id`,`author_or_editor_id`),
  KEY `fk_question_type1_idx` (`type_id`),
  KEY `fk_question_evaluation_category1_idx` (`evaluation_category_id`),
  KEY `fk_question_author_or_editor1_idx` (`author_or_editor_id`),
  CONSTRAINT `fk_question_author_or_editor1` FOREIGN KEY (`author_or_editor_id`) REFERENCES `author_or_editor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_evaluation_category1` FOREIGN KEY (`evaluation_category_id`) REFERENCES `evaluation_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_type1` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (4,'1','Comparing and representing quantities','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.906nbpvliw4g',3,1,2,'2015-16'),(5,'2','Circle geometry and measurement concepts','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.551928hu6exw',3,2,2,'2015-16'),(6,'3','Estimation and measurement of irregular shape','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.lfdsmpkiexu4',3,4,2,'2015-16'),(7,'4','Measures of the middle','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.oyueko9yjem0',3,1,2,'2015-16'),(8,'5','Geometric representation of linear relations','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.inwbw0bxn0hh',3,2,2,'2015-16'),(9,'6','Graphical representation of integers','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.ylsd9st5tgd',3,1,2,'2015-16'),(10,'7','Problem solving with rationals','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.zdsei3vlk5i',3,2,2,'2015-16'),(11,'8','Understanding measures of the middle','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.uk75eq5uig37',3,3,2,'2015-16'),(12,'9','Counting paths with 3D figures','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.rxommt3m1iq',3,4,2,'2015-16'),(13,'10','Representations of distance','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.r4uabr35vbsc',3,2,2,'2015-16'),(14,'11','Addition strategies','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.kbludbxnm4it',3,1,2,'2015-16'),(15,'12','Circle geometry and composite figures','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.hv8sa5b6rqig',3,2,2,'2015-16'),(16,'13','Geometric representation of quadratics','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.4q4rrh7wul92',3,1,2,'2015-16'),(17,'14','Understanding measures of the middle','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.igixycsoxjtz',3,1,2,'2015-16'),(18,'15','Basic probability and number sense','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.32k61nmhskk',3,2,2,'2015-16'),(19,'16','Representing data with statistics','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.1b0rmnn8qv2f',3,3,2,'2015-16'),(20,'17','Composite figures','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.cmy5br3dne2r',3,2,2,'2015-16'),(21,'18','Operations with integers','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.y7cy6kdov9bs',3,2,2,'2015-16'),(22,'P-IES 1-1','Volume optimization','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.c9zmjrpxls8a',1,4,2,'2015-16'),(23,'P-IES 1-2','Graphical representation of rationals','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.7r4doeiael8f',1,2,2,'2015-16'),(24,'P-IES 1-3','Probability and expected value','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.dyedtodoueq9',1,3,2,'2015-16'),(25,'P-IES 1-4','Geometric representation of linear relations','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.xcn2bgvsrj08',1,2,2,'2015-16'),(26,'IES 1-1','Geometric representation of quadratics','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.u09gxg4mxp39',2,2,2,'2015-16'),(27,'IES 1-2','Reasoning with volume','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.5wlwuaggyww',2,4,2,'2015-16'),(28,'IES 1-3','Multiplication strategies','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.zci46fshhq9o',2,1,2,'2015-16'),(29,'IES 1-4','Composite figures and rationals','https://docs.google.com/document/d/13s6BxEYHCm4vZCGv8B-crhAQbh0EDduVyjCFUGU3Rnk/edit#heading=h.8gt9znphpsmz',2,2,2,'2015-16');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_has_citation_or_source`
--

DROP TABLE IF EXISTS `question_has_citation_or_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_has_citation_or_source` (
  `question_id` int(11) NOT NULL,
  `citation_or_source_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`citation_or_source_id`),
  KEY `fk_question_has_citation_or_source_citation_or_source1_idx` (`citation_or_source_id`),
  KEY `fk_question_has_citation_or_source_question1_idx` (`question_id`),
  CONSTRAINT `fk_question_has_citation_or_source_citation_or_source1` FOREIGN KEY (`citation_or_source_id`) REFERENCES `citation_or_source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_has_citation_or_source_question1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_has_citation_or_source`
--

LOCK TABLES `question_has_citation_or_source` WRITE;
/*!40000 ALTER TABLE `question_has_citation_or_source` DISABLE KEYS */;
/*!40000 ALTER TABLE `question_has_citation_or_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_has_minor_expectation`
--

DROP TABLE IF EXISTS `question_has_minor_expectation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_has_minor_expectation` (
  `question_id` int(11) NOT NULL,
  `minor_expectation_id` int(11) NOT NULL,
  PRIMARY KEY (`question_id`,`minor_expectation_id`),
  KEY `fk_question_has_minor_expectation_minor_expectation1_idx` (`minor_expectation_id`),
  KEY `fk_question_has_minor_expectation_question1_idx` (`question_id`),
  CONSTRAINT `fk_question_has_minor_expectation_minor_expectation1` FOREIGN KEY (`minor_expectation_id`) REFERENCES `minor_expectation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_has_minor_expectation_question1` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_has_minor_expectation`
--

LOCK TABLES `question_has_minor_expectation` WRITE;
/*!40000 ALTER TABLE `question_has_minor_expectation` DISABLE KEYS */;
INSERT INTO `question_has_minor_expectation` VALUES (20,1),(4,5),(5,5),(6,5),(7,5),(9,5),(10,5),(11,5),(13,5),(14,5),(17,5),(18,5),(19,5),(21,5),(23,5),(24,5),(28,5),(29,5),(24,6),(25,8),(16,9),(26,9),(8,23),(25,23),(22,40),(27,40),(6,44),(15,44),(20,44),(24,44),(29,44),(12,50),(20,50);
/*!40000 ALTER TABLE `question_has_minor_expectation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `strand`
--

DROP TABLE IF EXISTS `strand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `strand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `title` varchar(255) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`course_id`),
  KEY `fk_strand_course1_idx` (`course_id`),
  CONSTRAINT `fk_strand_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `strand`
--

LOCK TABLES `strand` WRITE;
/*!40000 ALTER TABLE `strand` DISABLE KEYS */;
INSERT INTO `strand` VALUES (1,'A','Number Sense and Algebra',1),(2,'B','Linear Relations',1),(3,'C','Analytic Geometry',1),(4,'D','Measurement and Geometry',1),(5,'A','Quadratic Relations of the Form y = ax2 + bx + c',2),(6,'B','Analytic Geometry',2),(7,'C','Trigonometry',2);
/*!40000 ALTER TABLE `strand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'Assessment for learning'),(2,'Assessment of learning'),(3,'Assessment as learning');
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-24 17:43:32
