-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: fdb1034.awardspace.net
-- Generation Time: Nov 10, 2025 at 08:46 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS `blog_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `blog_system`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'approved',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `views` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `content`, `status`, `views`, `created_at`, `updated_at`) VALUES
(2, 1, 'Welcome to Our Blog', 'welcome-to-our-blog', 'Welcome to our amazing blog platform! This is a place where ideas meet creativity, and stories come to life. We are excited to have you here.\r\n\r\nOur blog is designed to provide you with insightful content, engaging discussions, and a community of like-minded individuals who share your interests. Whether you are here to read, write, or simply explore, we hope you find value in every visit.\r\n\r\nFeel free to create an account, share your thoughts, and engage with other members of our community. Happy blogging!', 'published', 0, '2025-11-10 19:59:06', '2025-11-10 19:59:06'),
(3, 1, 'Getting Started with Web Development', 'getting-started-with-web-development', 'Web development is an exciting field that combines creativity with technical skills. In this post, we will explore the basics of web development and what you need to get started.\n\n## The Fundamentals\n\nWeb development consists of three main technologies:\n- **HTML**: The structure of web pages\n- **CSS**: The styling and layout\n- **JavaScript**: The interactivity and dynamic behavior\n\n## Getting Started\n\nTo begin your journey, you will need a text editor and a web browser. Start by learning HTML, then move on to CSS, and finally JavaScript. Practice regularly and build projects to reinforce your learning.\n\nRemember, every expert was once a beginner. Keep learning and stay curious!', 'published', 2, '2025-11-10 20:35:15', '2025-11-10 20:44:47'),
(4, 2, 'The Art of Minimalist Design', 'the-art-of-minimalist-design', 'Minimalism in design is more than just a trend; it is a philosophy that emphasizes simplicity, clarity, and functionality. In this post, we explore the principles of minimalist design and how to apply them.\n\n## Core Principles\n\n1. **Less is More**: Remove unnecessary elements\n2. **White Space**: Use space strategically\n3. **Typography**: Choose clean, readable fonts\n4. **Color Palette**: Stick to a limited color scheme\n\n## Benefits\n\nMinimalist design improves user experience, reduces cognitive load, and creates a sense of elegance. It allows content to shine and makes interfaces more intuitive.\n\nWhether you are designing a website, app, or physical product, these principles will guide you toward creating beautiful, functional designs.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(5, 2, '10 Tips for Better Time Management', '10-tips-for-better-time-management', 'Time management is a crucial skill in today\'s fast-paced world. Here are 10 practical tips to help you manage your time more effectively:\n\n1. **Set Clear Goals**: Know what you want to achieve\n2. **Prioritize Tasks**: Focus on what matters most\n3. **Use a Calendar**: Schedule your activities\n4. **Eliminate Distractions**: Create a focused work environment\n5. **Take Breaks**: Rest to maintain productivity\n6. **Learn to Say No**: Protect your time\n7. **Batch Similar Tasks**: Work more efficiently\n8. **Use Time-Blocking**: Allocate specific time slots\n9. **Review Daily**: Reflect on your progress\n10. **Stay Flexible**: Adapt when needed\n\nImplementing these strategies will help you accomplish more while maintaining a healthy work-life balance.', 'published', 1, '2025-11-10 20:44:32', '2025-11-10 20:44:50'),
(6, 2, 'Understanding REST APIs', 'understanding-rest-apis', 'REST (Representational State Transfer) has become the standard for building web APIs. In this comprehensive guide, we explore what REST is and how to build RESTful services.\n\n## What is REST?\n\nREST is an architectural style that uses standard HTTP methods to communicate between clients and servers. It emphasizes stateless communication and resource-based design.\n\n## HTTP Methods\n\n- **GET**: Retrieve data\n- **POST**: Create new resources\n- **PUT**: Update existing resources\n- **DELETE**: Remove resources\n- **PATCH**: Partially update resources\n\n## Best Practices\n\n1. Use nouns for resource names: /users, /posts, /comments\n2. Use HTTP status codes correctly\n3. Version your API: /api/v1/\n4. Implement proper authentication (JWT, OAuth)\n5. Use pagination for large datasets\n6. Document your API thoroughly\n7. Implement rate limiting\n\n## Example\n\nA simple GET request to retrieve all posts:\n```\nGET /api/v1/posts\n```\n\nA POST request to create a new post:\n```\nPOST /api/v1/posts\nContent-Type: application/json\n\n{\n  \"title\": \"New Post\",\n  \"content\": \"Post content here\"\n}\n```\n\nBuilding with REST ensures your APIs are scalable, maintainable, and easy to understand.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(7, 2, 'JavaScript ES6 Features You Should Know', 'javascript-es6-features', 'JavaScript ES6 (ECMAScript 2015) introduced revolutionary features that changed how we write code. Let\'s explore the most important ones.\n\n## Arrow Functions\n\nArrow functions provide a concise syntax and bind `this` lexically:\n```javascript\nconst add = (a, b) => a + b;\nconst greet = name => `Hello, ${name}`;\n```\n\n## Template Literals\n\nTemplate literals make string interpolation cleaner:\n```javascript\nconst name = \"John\";\nconst age = 30;\nconsole.log(`${name} is ${age} years old`);\n```\n\n## Destructuring\n\nExtract values from objects and arrays easily:\n```javascript\nconst { name, age } = person;\nconst [first, second] = array;\n```\n\n## Classes\n\nES6 classes provide a cleaner syntax for object-oriented programming:\n```javascript\nclass Animal {\n  constructor(name) {\n    this.name = name;\n  }\n  \n  speak() {\n    console.log(`${this.name} makes a sound`);\n  }\n}\n```\n\n## Promises\n\nPromises handle asynchronous operations:\n```javascript\nconst promise = new Promise((resolve, reject) => {\n  setTimeout(() => resolve(\"Success!\"), 1000);\n});\n```\n\n## Modules\n\nES6 modules allow code organization:\n```javascript\nexport const myFunction = () => {};\nimport { myFunction } from \"./module.js\";\n```\n\nMastering these features is essential for modern JavaScript development.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(8, 2, 'Introduction to React Hooks', 'introduction-to-react-hooks', 'React Hooks revolutionized how we write React components by allowing us to use state and other React features without classes.\n\n## What are Hooks?\n\nHooks are functions that let you \"hook into\" React features. They allow you to use state in functional components.\n\n## useState Hook\n\nThe most commonly used hook for managing state:\n```javascript\nimport { useState } from \'react\';\n\nfunction Counter() {\n  const [count, setCount] = useState(0);\n  \n  return (\n    <div>\n      <p>Count: {count}</p>\n      <button onClick={() => setCount(count + 1)}>Increment</button>\n    </div>\n  );\n}\n```\n\n## useEffect Hook\n\nFor side effects like data fetching:\n```javascript\nimport { useEffect } from \'react\';\n\nfunction DataFetcher() {\n  const [data, setData] = useState(null);\n  \n  useEffect(() => {\n    fetch(\'/api/data\')\n      .then(res => res.json())\n      .then(data => setData(data));\n  }, []); // Empty dependency array = runs once\n  \n  return <div>{data && <p>{data.title}</p>}</div>;\n}\n```\n\n## Custom Hooks\n\nCreate reusable logic:\n```javascript\nfunction useFetch(url) {\n  const [data, setData] = useState(null);\n  const [loading, setLoading] = useState(true);\n  \n  useEffect(() => {\n    fetch(url)\n      .then(res => res.json())\n      .then(data => {\n        setData(data);\n        setLoading(false);\n      });\n  }, [url]);\n  \n  return { data, loading };\n}\n```\n\n## Common Hooks\n\n- **useContext**: Access context without nesting\n- **useReducer**: Complex state logic\n- **useCallback**: Memoize functions\n- **useMemo**: Memoize expensive computations\n- **useRef**: Access DOM elements directly\n\nReact Hooks make code more reusable and easier to understand.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(9, 2, 'Database Optimization Tips', 'database-optimization-tips', 'Database performance is crucial for application speed. Here are key optimization strategies.\n\n## Indexing\n\nCreate indexes on frequently queried columns:\n```sql\nCREATE INDEX idx_email ON users(email);\nCREATE INDEX idx_post_date ON posts(created_at);\n```\n\nIndexes speed up queries but slow down inserts/updates. Use strategically.\n\n## Query Optimization\n\n1. **Use SELECT with specific columns** instead of SELECT *\n2. **Avoid N+1 queries** by joining tables\n3. **Use LIMIT** to restrict results\n4. **Use EXPLAIN** to analyze query performance\n\n## Normalization\n\nOrganize data to eliminate redundancy:\n- Separate related data into tables\n- Use foreign keys for relationships\n- Avoid storing derived data\n\n## Caching\n\nImplement caching layers:\n- Redis for session data\n- Memcached for frequent queries\n- Database query result caching\n\n## Partitioning\n\nSplit large tables for better performance:\n```sql\nALTER TABLE posts PARTITION BY RANGE (YEAR(created_at)) (\n  PARTITION p2022 VALUES LESS THAN (2023),\n  PARTITION p2023 VALUES LESS THAN (2024)\n);\n```\n\n## Connection Pooling\n\nReuse database connections instead of creating new ones. Use tools like:\n- PHP: mysqli connection pooling\n- Node.js: Connection pool libraries\n- Python: SQLAlchemy pool\n\nRegular monitoring and optimization ensure consistent performance.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(10, 2, 'Color Theory in Web Design', 'color-theory-in-web-design', 'Color is one of the most powerful tools in web design. Understanding color theory helps create visually appealing and effective websites.\n\n## Color Basics\n\n### Primary Colors\nRed, Blue, Yellow - the foundation of all colors\n\n### Secondary Colors\nGreen, Orange, Purple - combinations of primary colors\n\n### Tertiary Colors\nRed-Orange, Yellow-Green, etc. - mix of primary and secondary\n\n## Color Schemes\n\n### Complementary\nColors opposite on the color wheel (e.g., blue and orange). Creates high contrast.\n\n### Analogous\nColors next to each other (e.g., blue, blue-green, green). Creates harmony.\n\n### Triadic\nThree colors equally spaced (e.g., red, yellow, blue). Balanced and vibrant.\n\n### Monochromatic\nVariations of one color. Professional and cohesive.\n\n## Psychology of Colors\n\n- **Red**: Energy, passion, urgency\n- **Blue**: Trust, calm, professionalism\n- **Green**: Growth, health, nature\n- **Yellow**: Optimism, happiness, caution\n- **Purple**: Luxury, creativity, mystery\n- **Orange**: Enthusiasm, success, warmth\n- **Black**: Power, elegance, mystery\n- **White**: Purity, simplicity, cleanliness\n\n## Best Practices\n\n1. Limit your palette to 3-4 main colors\n2. Ensure sufficient contrast for readability\n3. Consider cultural color meanings\n4. Test with colorblind users\n5. Use color to guide user attention\n6. Maintain consistency across pages\n\nChoosing the right colors enhances user experience and brand identity.', 'published', 1, '2025-11-10 20:44:32', '2025-11-10 20:44:56'),
(11, 2, 'UX Design Principles for Beginners', 'ux-design-principles', 'User Experience (UX) design focuses on creating products that are easy to use and enjoyable.\n\n## Core UX Principles\n\n### 1. User-Centered Design\n- Understand your users\n- Create personas\n- Conduct user research\n- Test with real users\n\n### 2. Simplicity\n- Remove unnecessary elements\n- One primary action per page\n- Clear information hierarchy\n- Avoid cognitive overload\n\n### 3. Consistency\n- Use consistent patterns\n- Maintain uniform styling\n- Predictable navigation\n- Standard icons and terminology\n\n### 4. Feedback\n- Acknowledge user actions\n- Show loading states\n- Provide error messages\n- Confirm destructive actions\n\n### 5. Accessibility\n- Design for all users\n- Consider color blindness\n- Provide keyboard navigation\n- Use semantic HTML\n- Add alt text to images\n\n### 6. Aesthetic Integrity\n- Visual design supports functionality\n- No distracting elements\n- Professional appearance\n- Appropriate for the domain\n\n## UX Process\n\n1. **Research**: Understand user needs\n2. **Design**: Create wireframes and prototypes\n3. **Test**: Get feedback from users\n4. **Iterate**: Improve based on feedback\n5. **Implement**: Build the final product\n6. **Monitor**: Track user behavior\n\nGood UX design turns users into loyal customers.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(12, 2, 'Creating Effective Wireframes', 'creating-effective-wireframes', 'Wireframes are blueprints for your digital products. They help communicate design ideas before investing in development.\n\n## What is a Wireframe?\n\nA wireframe is a low-fidelity visual representation of a webpage or app layout. It shows:\n- Layout and structure\n- Content placement\n- Navigation flow\n- User interactions\n\nWireframes typically exclude:\n- Colors\n- Typography details\n- Images\n- Visual styling\n\n## Types of Wireframes\n\n### Low-Fidelity\n- Hand-drawn or simple sketches\n- Quick and rough\n- Good for brainstorming\n\n### Mid-Fidelity\n- Created with tools like Figma\n- Shows layout and basic elements\n- Used for planning\n\n### High-Fidelity\n- Detailed and polished\n- Includes styling and interactions\n- Close to final design\n\n## Wireframing Best Practices\n\n1. **Start with user flows**: Understand the journey\n2. **Focus on structure**: Layout before details\n3. **Keep it simple**: Avoid over-complicating\n4. **Iterate quickly**: Get feedback early\n5. **Use grids**: Maintain alignment\n6. **Annotate clearly**: Explain interactions\n7. **Test usability**: Validate with users\n\n## Popular Tools\n\n- Figma: Free and collaborative\n- Sketch: Professional design tool\n- Adobe XD: Integrated design system\n- Balsamiq: Quick wireframing\n- Wireframe.cc: Simple online tool\n\nEffective wireframes bridge the gap between concept and implementation.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(13, 2, 'Home Workout Routine for Beginners', 'home-workout-routine-beginners', 'You don\'t need a gym to stay fit. Here\'s a simple home workout routine that requires no equipment.\n\n## Warm-up (5 minutes)\n\n- Jumping jacks: 2 minutes\n- Arm circles: 1 minute\n- Leg swings: 2 minutes\n\n## Main Workout (20 minutes)\n\nDo each exercise for 40 seconds, rest for 20 seconds.\n\n### Lower Body\n1. **Squats**: Works quads, hamstrings, glutes\n2. **Lunges**: Single-leg strength and balance\n3. **Glute Bridges**: Activate and strengthen glutes\n\n### Upper Body\n1. **Push-ups**: Chest, shoulders, triceps\n2. **Plank**: Core stability\n3. **Tricep Dips**: Using a chair\n\n### Cardio\n1. **Mountain Climbers**: Full-body cardio\n2. **Burpees**: Explosive full-body movement\n3. **High Knees**: Running in place cardio\n\n## Cool-down (5 minutes)\n\n- Walking in place: 2 minutes\n- Static stretching: 3 minutes\n\n## Tips for Success\n\n1. **Consistency**: Exercise 3-4 times per week\n2. **Progression**: Increase intensity gradually\n3. **Proper form**: Quality over quantity\n4. **Recovery**: Rest between workouts\n5. **Nutrition**: Eat balanced meals\n6. **Hydration**: Drink plenty of water\n\nStart with this routine and build your fitness foundation at home.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(14, 2, 'Nutrition Basics for a Healthy Lifestyle', 'nutrition-basics-healthy', 'Proper nutrition is the foundation of good health. Let\'s explore the basics of healthy eating.\n\n## Macronutrients\n\n### Proteins\n- Build and repair muscles\n- Found in: chicken, fish, eggs, beans, tofu\n- Aim for: 0.8-1g per pound of body weight\n\n### Carbohydrates\n- Primary energy source\n- Complex carbs: whole grains, vegetables, fruits\n- Simple carbs: processed foods (limit these)\n\n### Fats\n- Essential for hormone production\n- Healthy fats: avocado, nuts, olive oil, fatty fish\n- Limit: saturated and trans fats\n\n## Micronutrients\n\n### Vitamins\n- A, B, C, D, E, K - all essential\n- Eat variety of colorful foods\n\n### Minerals\n- Calcium, iron, magnesium, zinc\n- Found in vegetables, fruits, dairy, nuts\n\n## Meal Planning Tips\n\n1. **Balance your plate**:\n   - 50% vegetables and fruits\n   - 25% lean proteins\n   - 25% whole grains\n\n2. **Plan ahead**: Meal prep for the week\n3. **Read labels**: Understand what you eat\n4. **Hydrate**: Drink water throughout the day\n5. **Portion control**: Use smaller plates\n6. **Avoid processed**: Cook at home when possible\n7. **Moderation**: All foods okay in moderation\n\n## Common Mistakes\n\n- Skipping breakfast\n- Not eating enough vegetables\n- Drinking sugary beverages\n- Eating too fast\n- Neglecting fiber\n\nSmall nutritional changes lead to significant health improvements.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(15, 2, 'The Benefits of Regular Exercise', 'benefits-regular-exercise', 'Regular physical activity is one of the best investments in your health. Discover the numerous benefits.\n\n## Physical Benefits\n\n### Weight Management\n- Burns calories\n- Increases metabolism\n- Builds lean muscle\n\n### Cardiovascular Health\n- Strengthens heart\n- Improves circulation\n- Lowers blood pressure\n\n### Stronger Bones and Muscles\n- Increases bone density\n- Reduces osteoporosis risk\n- Improves strength and endurance\n\n### Reduced Disease Risk\n- Lower cancer risk\n- Prevents diabetes\n- Reduces heart disease risk\n\n## Mental Health Benefits\n\n### Mood Enhancement\n- Releases endorphins (feel-good chemicals)\n- Reduces depression and anxiety\n- Improves sleep quality\n\n### Cognitive Function\n- Improves memory\n- Enhances focus and concentration\n- Reduces dementia risk\n\n### Stress Relief\n- Reduces cortisol levels\n- Provides mental escape\n- Builds confidence\n\n## Recommended Activity\n\n- **Aerobic**: 150 minutes moderate or 75 minutes vigorous per week\n- **Strength**: 2+ days per week\n- **Flexibility**: Daily stretching\n\n## Getting Started\n\n1. Choose activities you enjoy\n2. Start slowly and build up\n3. Find an accountability partner\n4. Track your progress\n5. Mix different activities\n\nThe best exercise is the one you\'ll actually do consistently.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(16, 2, 'Budget Travel Tips and Tricks', 'budget-travel-tips', 'Travel doesn\'t have to be expensive. Here are proven strategies to explore the world on a budget.\n\n## Accommodation\n\n### Budget-Friendly Options\n1. **Hostels**: Social and affordable\n2. **Airbnb**: Often cheaper than hotels\n3. **Couchsurfing**: Free accommodations\n4. **Camping**: Nature and budget-friendly\n5. **House-sitting**: Free lodging and local experience\n\n### Tips\n- Book during off-season\n- Stay outside tourist areas\n- Book directly with properties\n- Look for deals on booking sites\n\n## Transportation\n\n1. **Flights**: Use flight comparison tools\n2. **Bus**: Cheaper than trains\n3. **Walking**: Explore locally\n4. **Public transit**: Invest in city passes\n5. **Ride-sharing**: Share costs with others\n\n## Food\n\n- Eat where locals eat\n- Visit markets and street food vendors\n- Cook your own meals\n- Skip tourist restaurants\n- Share dishes\n\n## Activities\n\n1. Many museums have free hours\n2. Hiking and nature walks (free)\n3. Walking tours\n4. Local festivals and events\n5. Beach and park visits (free)\n\n## Planning\n\n1. Travel during shoulder season\n2. Set a daily budget\n3. Travel with others\n4. Get a travel insurance deal\n5. Work remotely while traveling\n\n## Destinations\n\nBudget-friendly countries:\n- Southeast Asia\n- Central America\n- Eastern Europe\n- South America\n- Parts of Africa\n\nWith smart planning, amazing travel experiences are within reach.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(17, 2, 'Top 10 Must-Visit Destinations', 'top-10-must-visit-destinations', 'The world is full of incredible places. Here are 10 destinations everyone should visit.\n\n## 1. Tokyo, Japan\n**Why**: Ancient temples meet modern technology\n- Tsukiji Fish Market\n- Senso-ji Temple\n- Shibuya Crossing\n- Mount Fuji day trip\n\n## 2. Barcelona, Spain\n**Why**: Art, architecture, beaches\n- Sagrada Familia\n- Park Güell\n- Gothic Quarter\n- Mediterranean beaches\n\n## 3. Paris, France\n**Why**: Romance and culture\n- Eiffel Tower\n- Louvre Museum\n- Notre-Dame\n- Seine River cruise\n\n## 4. New York, USA\n**Why**: Energy and diversity\n- Times Square\n- Central Park\n- Statue of Liberty\n- World-class museums\n\n## 5. Bangkok, Thailand\n**Why**: Exotic culture and cuisine\n- Grand Palace\n- Floating markets\n- Street food\n- Thai temples\n\n## 6. Rome, Italy\n**Why**: History and art\n- Colosseum\n- Vatican City\n- Roman Forum\n- Trevi Fountain\n\n## 7. Istanbul, Turkey\n**Why**: East meets West\n- Blue Mosque\n- Hagia Sophia\n- Grand Bazaar\n- Bosphorus cruise\n\n## 8. Sydney, Australia\n**Why**: Stunning nature\n- Opera House\n- Bondi Beach\n- Blue Mountains\n- Great Barrier Reef\n\n## 9. Dubai, UAE\n**Why**: Luxury and adventure\n- Burj Khalifa\n- Desert safari\n- Palm Islands\n- Shopping malls\n\n## 10. Rio de Janeiro, Brazil\n**Why**: Mountains, beaches, culture\n- Christ the Redeemer\n- Sugarloaf Mountain\n- Copacabana Beach\n- Carnival (if timed right)\n\nEach destination offers unique experiences and memories.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(18, 2, 'Remote Work Best Practices', 'remote-work-best-practices', 'Working from home offers flexibility but also challenges. Here are best practices for productive remote work.\n\n## Setting Up Your Workspace\n\n1. **Dedicated space**: Separate work from living areas\n2. **Comfortable furniture**: Invest in ergonomic desk and chair\n3. **Good lighting**: Reduce eye strain\n4. **Minimize distractions**: Close unnecessary tabs and apps\n5. **Good internet**: Ensure reliable connection\n\n## Daily Routine\n\n- **Start and end time**: Maintain structure\n- **Dress professionally**: Mentally prepare for work\n- **Morning routine**: Exercise or meditation\n- **Regular breaks**: Refresh your mind\n- **Lunch away from desk**: Truly disconnect\n\n## Communication\n\n1. **Use video calls**: Build connections\n2. **Respond promptly**: Show engagement\n3. **Be clear**: Written communication matters more\n4. **Over-communicate**: Ensure team alignment\n5. **Check-ins**: Schedule regular meetings\n\n## Productivity Tools\n\n- Project management: Asana, Monday.com, Trello\n- Communication: Slack, Microsoft Teams\n- Time tracking: Toggl, Clockify\n- Note-taking: Notion, Evernote\n- Calendar: Google Calendar, Outlook\n\n## Managing Distractions\n\n1. **Silence notifications**: Focus time matters\n2. **Block time**: Dedicated work sessions\n3. **Set boundaries**: Tell family/roommates\n4. **Avoid multitasking**: One task at a time\n5. **Social media**: Limit during work hours\n\n## Work-Life Balance\n\n- Close your workspace at day\'s end\n- Don\'t work weekends\n- Take vacation days\n- Maintain social connections\n- Exercise regularly\n\nRemote work success requires discipline and intentional habits.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32'),
(19, 2, 'The Pomodoro Technique Explained', 'pomodoro-technique-explained', 'The Pomodoro Technique is a simple but powerful time management method that boosts productivity.\n\n## How It Works\n\n1. **Choose task**: Select what you want to accomplish\n2. **Set timer**: 25 minutes (one Pomodoro)\n3. **Focus**: Work without interruptions\n4. **Timer rings**: Take 5-minute break\n5. **Repeat**: After 4 Pomodoros, take 15-30 minute break\n\n## Why It Works\n\n- **Combat procrastination**: 25 minutes feels manageable\n- **Reduce perfectionism**: Time limit forces progress\n- **Minimize distractions**: You know break is coming\n- **Regular breaks**: Maintain focus and energy\n- **Prevent burnout**: Structured work-rest balance\n\n## Tips for Success\n\n### During Pomodoro\n- Silence phone and apps\n- Close email and messaging\n- Work in dedicated space\n- Focus on single task\n- Track completed Pomodoros\n\n### During Breaks\n- Move around\n- Stretch\n- Get water or tea\n- Look away from screen\n- Breathe deeply\n\n## Variations\n\n### Short tasks\n- Use 15-minute Pomodoros\n- Shorter breaks\n\n### Deep work\n- Extend to 50-minute sessions\n- Longer breaks\n\n### Learning\n- Alternate: 25 min study, 5 min review\n\n## Tracking Progress\n\n- Use Pomodoro timer apps\n- Keep checklist\n- Track daily totals\n- Celebrate milestones\n\n## Common Mistakes\n\n- Using timers too rigidly\n- Skipping breaks\n- Picking too many tasks\n- Not eliminating interruptions\n- Ignoring fatigue\n\nThe Pomodoro Technique turns time into your productivity ally.', 'published', 0, '2025-11-10 20:44:32', '2025-11-10 20:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `bio`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'System Administrator', '2025-11-10 19:58:23', '2025-11-10 19:58:23'),
(2, 'Sabbir', 'sabbir0849@gmail.com', '$2y$10$79zZKSFDa6t8gd4OMWmleeR5ih.93kFpU/PzFOBR9HBlcjZ10mBqu', 'Sabbir Ahmed', NULL, '2025-11-10 20:01:08', '2025-11-10 20:01:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_slug` (`slug`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
