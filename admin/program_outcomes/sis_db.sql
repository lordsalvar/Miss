-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2025 at 02:20 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_history`
--

CREATE TABLE `academic_history` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `semester` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `school_year` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1= New,\r\n2= Regular,\r\n3= Returnee,\r\n4= Transferee',
  `end_status` tinyint(3) NOT NULL DEFAULT 0 COMMENT '0=pending,\r\n1=Completed,\r\n2=Dropout,\r\n3=failed,\r\n4=Transferred-out,\r\n5=Graduated',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollment`
--

CREATE TABLE `course_enrollment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `school_year` varchar(10) NOT NULL,
  `semester` int(1) NOT NULL,
  `courses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`courses`)),
  `edit` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `id` int(11) NOT NULL,
  `catalog_number` varchar(255) NOT NULL,
  `course_title` varchar(255) NOT NULL,
  `credit_unit` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `year_level` varchar(255) NOT NULL,
  `program_id` int(255) NOT NULL,
  `prerequisite` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `delete_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`id`, `catalog_number`, `course_title`, `credit_unit`, `semester`, `year_level`, `program_id`, `prerequisite`, `department_id`, `delete_flag`) VALUES
(9, 'ICS 101', 'Introduction to Computing', '2', 'First', 'First', 23, '', 0, 0),
(10, 'ICS 101L', 'Introduction to Computing Lab	', '1', 'First', 'First', 23, '', 0, 0),
(11, 'Math Plus', 'Pre-Calculus for Non-STEM	', '1', 'First', 'First', 23, '', 0, 0),
(12, 'ICS 102	', 'Computer Programming 1	', '2', 'First', 'First', 23, '', 0, 0),
(13, 'ICS 102L	', 'Computer Programming 1 Lab	', '1', 'First', 'First', 23, '', 0, 0),
(14, 'GEN ED 1	', 'Understanding the Self	', '3', 'First', 'First', 23, '', 0, 0),
(15, 'GEN ED 2	', 'Reading in the Philippine History	', '3', 'First', 'First', 23, '', 0, 0),
(16, 'GEN ED 10	', 'Technical Writing in ICT	', '3', 'First', 'First', 23, '', 0, 0),
(17, 'RS 1	', 'Gods Salvific Act	', '3', 'First', 'First', 23, '', 0, 0),
(18, 'NSTP 1	', 'National Service Training Program 1	', '3', 'First', 'First', 23, '', 0, 0),
(19, 'PE 1	', 'Movement Enhancement (ME)	', '2', 'First', 'First', 23, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cpo`
--

CREATE TABLE `cpo` (
  `cpo_id` int(11) NOT NULL,
  `cpo_code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpo`
--

INSERT INTO `cpo` (`cpo_id`, `cpo_code`, `description`, `date_created`, `date_updated`) VALUES
(1, 'CPO01', 'Discuss the latest developments in IT and Computing.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(2, 'CPO02', 'Effectively communicate orally and in writing in English and Filipino.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(3, 'CPO03', 'Work effectively in multidisciplinary and multicultural teams.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(4, 'CPO04', 'Act in recognition of professional, social, and ethical responsibility.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(5, 'CPO05', 'Preserve and promote Filipino historical and cultural heritage.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(6, 'CPO06', 'Analyze complex problems and define computing requirements.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(7, 'CPO07', 'Apply computing and other knowledge domains to real-world problems.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(8, 'CPO08', 'Design and develop computing solutions using a system-level perspective.', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(9, 'CPO09', 'Utilize modern computing tools.', '2025-02-10 16:50:15', '2025-02-10 16:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_list`
--

INSERT INTO `department_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(7, 'CCIS', 'College of Computing in Information Sciences\r\n', 1, 0, '2025-01-09 15:25:17', '2025-01-18 17:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_list`
--

CREATE TABLE `faculty_list` (
  `id` int(11) NOT NULL,
  `roll` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `dob` date NOT NULL,
  `contact` varchar(15) NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_list`
--

INSERT INTO `faculty_list` (`id`, `roll`, `firstname`, `middlename`, `lastname`, `gender`, `dob`, `contact`, `present_address`, `permanent_address`, `status`) VALUES
(6, '2025-002', '21312312', 'asdfsadfasdfsda', 'asdfasdf', 'Male', '2025-01-14', 'sadfsdsdasda', 'sdasdasd', 'dasdasfsdfasd', 1),
(7, '2025-003', '33333333', '333333333', '33333333333', 'Male', '2025-01-13', '33333333333333', '333333333333', '33333333333', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_student_list`
--

CREATE TABLE `faculty_student_list` (
  `faculty_id` int(255) DEFAULT NULL,
  `student_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_student_list`
--

INSERT INTO `faculty_student_list` (`faculty_id`, `student_id`) VALUES
(7, 3),
(7, 7),
(7, 9),
(7, 16),
(6, 14),
(7, 15),
(7, 14);

-- --------------------------------------------------------

--
-- Table structure for table `graduate_attributes`
--

CREATE TABLE `graduate_attributes` (
  `attribute_id` int(11) NOT NULL,
  `attribute_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `graduate_attributes`
--

INSERT INTO `graduate_attributes` (`attribute_id`, `attribute_name`, `description`, `date_created`, `date_updated`) VALUES
(1, 'Knowledge for Solving Computing Problems', 'Applies computing fundamentals to analyze and solve complex computing problems.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(2, 'Problem Analysis', 'Identifies and formulates solutions to computing problems.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(3, 'Design and Development of Solutions', 'Develops and evaluates computing solutions using appropriate methodologies.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(4, 'Modern Tool Usage', 'Uses modern computing tools effectively and responsibly.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(5, 'Individual & Team Work', 'Works effectively as an individual and in teams.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(6, 'Communication', 'Communicates effectively with the computing community and society.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(7, 'Computing Professionalism and Ethics', 'Recognizes ethical, legal, and professional responsibilities in computing practice.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(8, 'Life-Long Learning', 'Recognizes the need for continuous professional learning.', '2025-02-10 16:50:32', '2025-02-10 16:50:32'),
(9, 'CJC Unique Program Outcomes', '', '2025-02-10 23:58:03', '2025-02-10 23:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `igo`
--

CREATE TABLE `igo` (
  `igo_id` int(11) NOT NULL,
  `igo_code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `link_to_vm` varchar(50) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `igo`
--

INSERT INTO `igo` (`igo_id`, `igo_code`, `description`, `link_to_vm`, `date_created`, `date_updated`) VALUES
(1, 'IGO01', 'Demonstrate understanding and mastery of fundamental knowledge and skills.', 'Excellence', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(2, 'IGO02', 'Exercise critical and creative thinking in problem-solving.', 'Excellence', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(3, 'IGO03', 'Apply effective communication skills.', 'Excellence', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(4, 'IGO04', 'Utilize lifelong learning skills.', 'Excellence', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(5, 'IGO05', 'Contribute to nation-building through technology application.', 'Excellence', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(6, 'IGO06', 'Work effectively in multi-disciplinary and multicultural teams.', 'Community', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(7, 'IGO07', 'Actualize professional practices with community values.', 'Community', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(8, 'IGO08', 'Hold personal values and beliefs as ethical professionals.', 'Apostleship', '2025-02-10 16:50:15', '2025-02-10 16:50:15'),
(9, 'IGO09', 'Exhibit professional character as responsible stewards.', 'Apostleship', '2025-02-10 16:50:15', '2025-02-10 16:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `program_list`
--

CREATE TABLE `program_list` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `delete_flag` tinyint(1) DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_list`
--

INSERT INTO `program_list` (`id`, `department_id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(23, 7, 'BSIT', 'Bachelor of Science in Information Technology', 1, 0, '2025-01-29 11:34:43', NULL),
(24, 7, 'BSCS', 'Bachelor of Science in Computer Science', 1, 0, '2025-01-29 11:35:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_outcomes`
--

CREATE TABLE `program_outcomes` (
  `po_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `po_code` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `performance_indicator` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `graduate_attribute_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_outcomes`
--

INSERT INTO `program_outcomes` (`po_id`, `program_id`, `po_code`, `description`, `performance_indicator`, `date_created`, `date_updated`, `graduate_attribute_id`) VALUES
(1, 24, 'CS01', 'Apply understanding of fundamental computing\nknowledge and skills, computing specialization,\nmathematics, science, and knowledge in computer\nscience domain to provide abstraction and\nconceptualization of the computing models from\ndefined problems and requirements.', 'Completed and successfully defended CS Thesis.', '2025-02-10 16:50:15', '2025-02-10 17:38:53', 1),
(2, 24, 'CS02', 'Identify, analyze, formulate research literature, and\nsolve complex computing problems and requirements\nreaching substantiated conclusions relevant for\nnational development through the use knowledge and\nskills of computing fundamentals, computing\nspecialization, mathematics, science, and other\nrelevant domain disciplines in Computer Science', 'Documented computing solutions and/or software/hardware requirements specification following appropriate standards.', '2025-02-10 16:50:15', '2025-02-10 17:39:10', 2),
(3, 24, 'CS03', 'Demonstrate understanding and mastery of\nmathematical foundations, algorithmic principles and\ncomputer science theory in the modeling and\ndesigning computer based systems in a way that\ndemonstrates critical and creative thinking on the\ntradeoffs involved in design choices\nDemonstrate understanding and mastery of\nmathematical foundations, algorithmic principles and\ncomputer science theory in the modeling and\ndesigning computer based systems in a way that\ndemonstrates critical and creative thinking on the\ntradeoffs involved in design choices\n', 'Completed a documented computer-based solution with the use of algorithmic and/or mathematical principles.', '2025-02-10 16:50:15', '2025-02-10 17:39:50', 3),
(4, 24, 'CS04', 'Design, development and use information systems\nthrough the use of relevant knowledge, understanding\nand skills in information security along with ethical\npractices.', 'Fully implemented and documented a system integrating security solutions.', '2025-02-10 16:50:15', '2025-02-10 17:40:22', 3),
(5, 24, 'CS05', 'Design and evaluate solutions for complex computing\nproblems, and design and evaluate systems,\ncomponents, or processes that meet specified needs in\na way that demonstrates ethical and professional\ncharacter through consideration of public health and\nsafety, culture, society, and environment.', 'Conducted systems testing and evaluation and proposed system modifications based on recommendations.', '2025-02-10 16:50:15', '2025-02-10 17:40:45', 3),
(6, 24, 'CS06', 'Create, select, adapt and apply appropriate\ntechniques, resources and modern computing tools used in professional practice to complex computing\nactivities, with an understanding of the limitations to\naccomplish common goal and excellence.', 'Used an appropriate development tool to deliver solutions based on requirements specification.', '2025-02-10 16:50:15', '2025-02-10 17:41:16', 4),
(7, 24, 'CS07', 'Function effectively as an individual and as a member\nor leader, in diverse, multidisciplinary, and multicultural\nsettings considering a sense of community and\nprofessional ethics', 'Worked with the group in development of computing solutions or project.', '2025-02-10 16:50:15', '2025-02-10 22:59:31', 5),
(8, 24, 'CS08', 'Communicate effectively with the computing\ncommunity and with society at large about complex\ncomputing activities and its relevant contribution for\nnational development by being able to comprehend\nand write effective reports and design documentation,\nmake effective oral and written presentations, and give\nand understand clear instructions.', 'Presented a proposal on computing solution or a project in a class or in a public forum.', '2025-02-10 16:50:15', '2025-02-10 22:59:41', 6),
(9, 24, 'CS09', 'The ability to recognize the legal, social, ethical and\nprofessional issues and exhibit professional character\ninvolved in the utilization of computer technology and\nbe guided by the professional, ethical and legal\npractices', 'Immersed/Exposed in an actual working environment in industry.', '2025-02-10 16:50:15', '2025-02-10 22:59:54', 7),
(10, 24, 'CS10', 'Recognize the need, and have the ability, to engage in\nindependent learning in pursuit for personal and\ncontinual development and excellence in professional\npractice', 'Created a report on a conducted independent learning activity.', '2025-02-10 16:50:15', '2025-02-10 23:00:06', 8),
(11, 24, 'CS11', 'Exemplify Christian values and compassion, inspire by\nthe spirituality of the Sacred Heart of Jesus, in all aspects\nof professional practice.', 'Demonstrated a consistent pattern of compassionate behavior.', '2025-02-10 16:50:15', '2025-02-10 23:58:15', 9),
(12, 23, 'IT01', 'Apply knowledge and mastery in fundamentals of\ncomputing, science, and mathematics appropriate\nto the discipline to provide solution to IT-related\nproblems.', 'Completed and successfully defended IT Capstone project.', '2025-02-10 16:50:15', '2025-02-10 23:02:44', 1),
(13, 23, 'IT02', 'Understand best practices and standards and their\napplications as an IT professional, contributing to\nsocial progress and development', 'Contributed to social progress and development.', '2025-02-10 16:50:15', '2025-02-10 23:02:55', 1),
(14, 23, 'IT03', 'Analyze complex problems, and exercise critical\nand creative thinking in defining and identifying\ncomputing requirements and to formulate its\nappropriate solution', 'Documented computing solutions following appropriate standards.', '2025-02-10 16:50:15', '2025-02-10 23:03:04', 2),
(15, 23, 'IT04', 'Identify and analyze user needs and take them into\naccount in providing solutions through critical and\ncreative selection, creation, evaluation and\nadministration of computer-based systems', 'Formulated System Requirement Specification.', '2025-02-10 16:50:15', '2025-02-10 23:03:12', 2),
(16, 23, 'IT05', 'Design, implement, and evaluate computer-based\nsystems, processes, components, or programs to\nmeet desired needs and requirements under various\nconstraints in a way that demonstrates critical and\ncreative thinking.', 'Completed a documented computer-based solution that addresses specific conditions.', '2025-02-10 16:50:15', '2025-02-10 23:03:18', 3),
(17, 23, 'IT06', 'Actualize professional practice through Integration\nof IT-based solutions into the user environment\neffectively in contribution to national development.', 'Deployed a developed solution.', '2025-02-10 16:50:15', '2025-02-10 23:03:27', 3),
(18, 23, 'IT07', 'Apply knowledge and mastery in providing solutions\nthrough the use of current techniques, skills, tools and\npractices necessary for the IT profession.', 'Used an appropriate development tool to deliver solutions based on requirements specification.', '2025-02-10 16:50:15', '2025-02-10 23:04:15', 4),
(19, 23, 'IT08', 'Function effectively as a member or leader of a\nmulti-disciplinary and multicultural development team with a sense of community in recognition of\ndifferent roles within a team to accomplish a\ncommon goal', 'Assisted in the development and implementation of team tasking schedules and deliverables.', '2025-02-10 16:50:15', '2025-02-10 23:04:34', 5),
(20, 23, 'IT09', 'Embody professional character and work effectively\nwith the team on the creation of an effective IT\nproject plan.', 'Created an IT project plan.', '2025-02-10 16:50:15', '2025-02-10 23:04:41', 5),
(21, 23, 'IT10', 'Communicate effectively with the computing\ncommunity and with society at large about complex\ncomputing activities and its relevant contribution for\nnational development through logical writing, oral\nand written presentations, and give and understand\nclear instructions.', 'Presented a proposal solution in a class or in a public forum.', '2025-02-10 16:50:15', '2025-02-10 23:04:47', 6),
(22, 23, 'IT11', 'Analyze the local and global impact of information\ntechnology on individuals, organizations, and\nsociety in a way that exhibits ethical and professional\nvalues.', 'Immersed/Exposed in an actual working environment in industry.', '2025-02-10 16:50:15', '2025-02-10 23:06:05', 7),
(23, 23, 'IT12', 'Understand professional, ethical, legal, security, and\nsocial issues and responsibilities in the utilization of\ninformation technology.', 'Provided a report on practicum experiences.', '2025-02-10 16:50:15', '2025-02-10 23:05:44', 7),
(24, 23, 'IT13', 'Recognize the need for and engage in planning selflearning and improving performance in pursuit for\npersonal and continual development and\nexcellence in professional practice.', 'Created a report on independent learning.', '2025-02-10 16:50:15', '2025-02-10 23:05:13', 8),
(25, 23, 'IT14', 'Exemplify Christian values and compassion, inspire\nby the spirituality of the Sacred Heart of Jesus, in all\naspects of professional practice.', 'Demonstrated compassionate and ethical behavior.', '2025-02-10 16:50:15', '2025-02-10 23:58:18', 9),
(29, 24, 'ddasdas', 'dasdsa', 'dsadas', '2025-02-11 01:15:54', '2025-02-11 01:15:54', 6),
(30, 24, 'ddasdas', 'dasdsa', 'dsadas', '2025-02-11 01:15:54', '2025-02-11 01:15:54', 6);

-- --------------------------------------------------------

--
-- Table structure for table `program_outcomes_cpo`
--

CREATE TABLE `program_outcomes_cpo` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `cpo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_outcomes_cpo`
--

INSERT INTO `program_outcomes_cpo` (`id`, `po_id`, `cpo_id`) VALUES
(1, 1, 7),
(2, 2, 6),
(3, 3, 8),
(4, 4, 8),
(5, 5, 8),
(6, 6, 9),
(7, 7, 3),
(8, 8, 2),
(9, 9, 4),
(10, 10, 1),
(11, 12, 7),
(15, 16, 8),
(17, 18, 9),
(18, 19, 3),
(20, 21, 2),
(21, 23, 4),
(22, 24, 1),
(23, 14, 6),
(26, 29, 2),
(27, 29, 4),
(28, 30, 2),
(29, 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `program_outcomes_igo`
--

CREATE TABLE `program_outcomes_igo` (
  `id` int(11) NOT NULL,
  `po_id` int(11) NOT NULL,
  `igo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_outcomes_igo`
--

INSERT INTO `program_outcomes_igo` (`id`, `po_id`, `igo_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 2, 5),
(6, 3, 1),
(7, 3, 2),
(8, 4, 1),
(9, 4, 8),
(10, 5, 1),
(11, 5, 2),
(12, 5, 8),
(13, 5, 9),
(14, 6, 1),
(15, 6, 2),
(16, 7, 6),
(17, 7, 7),
(18, 7, 8),
(19, 8, 3),
(20, 8, 5),
(21, 9, 8),
(22, 9, 9),
(23, 10, 4),
(24, 11, 9),
(25, 12, 1),
(26, 13, 1),
(27, 13, 9),
(28, 14, 2),
(29, 15, 2),
(31, 16, 2),
(33, 17, 5),
(34, 17, 7),
(35, 18, 1),
(36, 18, 2),
(37, 19, 6),
(38, 19, 7),
(39, 20, 6),
(40, 20, 9),
(41, 21, 3),
(42, 22, 9),
(43, 21, 5),
(44, 22, 8),
(45, 23, 8),
(46, 23, 9),
(47, 24, 4),
(48, 25, 9),
(51, 29, 2),
(52, 29, 4),
(53, 30, 2),
(54, 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `roll` varchar(100) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(100) NOT NULL,
  `contact` text NOT NULL,
  `present_address` text NOT NULL,
  `permanent_address` text NOT NULL,
  `dob` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `year_level` int(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `school_year` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `roll`, `firstname`, `middlename`, `lastname`, `gender`, `contact`, `present_address`, `permanent_address`, `dob`, `status`, `delete_flag`, `date_created`, `date_updated`, `year_level`, `program`, `school_year`) VALUES
(11, '33', '333', '333', '333', 'Male', '33', '33', '33', '2025-01-14', 1, 0, '2025-01-25 15:48:52', NULL, 1, 'BSCS', '0'),
(12, '4', '4', '', '4', 'Male', '4', '44', '4444', '2025-01-07', 1, 0, '2025-01-25 15:49:35', NULL, 1, 'BSCS', '0'),
(13, '555', '555', '', '555', 'Male', '555555555', '555', '55555', '2025-01-15', 1, 0, '2025-01-25 15:50:13', NULL, 1, 'BSCS', '0'),
(15, '5535432', '32154324', '213214', '123214', 'Male', '213214', '21321', '4124213', '2025-01-15', 1, 0, '2025-01-25 15:51:16', '2025-02-07 21:14:04', 1, 'BSCS', '2024-2025'),
(18, '', 'Edmund', 'P', 'Nillas III', 'Male', '', '', '', '0000-00-00', 1, 0, '2025-02-10 14:27:30', NULL, 1, 'BSCS', ''),
(19, '', 'Mikus', 'Mikus', 'Ahaman?', 'Male', '', '', '', '0000-00-00', 1, 0, '2025-02-10 14:33:15', NULL, 1, 'BSCS', '');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject_list`
--

CREATE TABLE `student_subject_list` (
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_subject_list`
--

INSERT INTO `student_subject_list` (`student_id`, `subject_id`) VALUES
(8, 1),
(3, 1),
(9, 1),
(3, 10),
(9, 10),
(14, 19),
(12, 19);

-- --------------------------------------------------------

--
-- Table structure for table `subject_list`
--

CREATE TABLE `subject_list` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `delete_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_list`
--

INSERT INTO `subject_list` (`id`, `course_id`, `status`, `delete_flag`) VALUES
(10, 3, 1, 0),
(11, 4, 1, 1),
(13, 7, 1, 0),
(14, 9, 1, 1),
(15, 12, 1, 1),
(16, 11, 1, 1),
(17, 9, 1, 1),
(18, 9, 1, 1),
(19, 9, 1, 0),
(20, 19, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'CCIS - MIS'),
(6, 'short_name', ''),
(11, 'logo', 'uploads/CCIS.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/Norbert.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` enum('Administrator','Faculty','Student') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `roll` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `dob` date NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `year_level` int(11) DEFAULT NULL,
  `program` varchar(100) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `type`, `status`, `roll`, `gender`, `dob`, `contact`, `address`, `delete_flag`, `year_level`, `program`, `school_year`) VALUES
(1, 'Edu', NULL, 'Nillas III', 'Edu', '202cb962ac59075b964b07152d234b70', 'Student', 0, NULL, 'male', '0000-00-00', NULL, NULL, 0, NULL, NULL, NULL),
(2, 'Mikus', NULL, 'Ahaman?', 'mekmek', '202cb962ac59075b964b07152d234b70', 'Student', 0, NULL, 'male', '0000-00-00', NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(10, 'Kevin', NULL, 'Bacarisa', 'Kebs', '202cb962ac59075b964b07152d234b70', NULL, NULL, 1, 1, '2025-01-09 15:38:00', '2025-01-10 11:41:22'),
(11, 'Miko', NULL, 'Haman', 'MK', '202cb962ac59075b964b07152d234b70', NULL, NULL, 2, 1, '2025-01-10 11:52:18', '2025-02-07 22:08:44'),
(13, 'Franie', NULL, 'Berjame', 'Frankie', '202cb962ac59075b964b07152d234b70', NULL, NULL, 3, 1, '2025-02-07 22:10:19', NULL),
(15, 'Rene', NULL, 'Ronquillo', 'Dondon', '202cb962ac59075b964b07152d234b70', NULL, NULL, 3, 1, '2025-02-08 15:35:46', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_history`
--
ALTER TABLE `academic_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cpo`
--
ALTER TABLE `cpo`
  ADD PRIMARY KEY (`cpo_id`);

--
-- Indexes for table `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_list`
--
ALTER TABLE `faculty_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `graduate_attributes`
--
ALTER TABLE `graduate_attributes`
  ADD PRIMARY KEY (`attribute_id`);

--
-- Indexes for table `igo`
--
ALTER TABLE `igo`
  ADD PRIMARY KEY (`igo_id`);

--
-- Indexes for table `program_list`
--
ALTER TABLE `program_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `program_outcomes`
--
ALTER TABLE `program_outcomes`
  ADD PRIMARY KEY (`po_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `graduate_attribute_id` (`graduate_attribute_id`);

--
-- Indexes for table `program_outcomes_cpo`
--
ALTER TABLE `program_outcomes_cpo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cpo_id` (`cpo_id`),
  ADD KEY `fk_cpo_po` (`po_id`);

--
-- Indexes for table `program_outcomes_igo`
--
ALTER TABLE `program_outcomes_igo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `igo_id` (`igo_id`),
  ADD KEY `fk_igo_po` (`po_id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_list`
--
ALTER TABLE `subject_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_history`
--
ALTER TABLE `academic_history`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `course_list`
--
ALTER TABLE `course_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `cpo`
--
ALTER TABLE `cpo`
  MODIFY `cpo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faculty_list`
--
ALTER TABLE `faculty_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `graduate_attributes`
--
ALTER TABLE `graduate_attributes`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `igo`
--
ALTER TABLE `igo`
  MODIFY `igo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `program_list`
--
ALTER TABLE `program_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `program_outcomes`
--
ALTER TABLE `program_outcomes`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `program_outcomes_cpo`
--
ALTER TABLE `program_outcomes_cpo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `program_outcomes_igo`
--
ALTER TABLE `program_outcomes_igo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `subject_list`
--
ALTER TABLE `subject_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_history`
--
ALTER TABLE `academic_history`
  ADD CONSTRAINT `academic_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `academic_history_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `program_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_enrollment`
--
ALTER TABLE `course_enrollment`
  ADD CONSTRAINT `course_enrollment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_list`
--
ALTER TABLE `program_list`
  ADD CONSTRAINT `program_list_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_outcomes`
--
ALTER TABLE `program_outcomes`
  ADD CONSTRAINT `program_outcomes_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `program_list` (`id`),
  ADD CONSTRAINT `program_outcomes_ibfk_2` FOREIGN KEY (`graduate_attribute_id`) REFERENCES `graduate_attributes` (`attribute_id`) ON DELETE SET NULL;

--
-- Constraints for table `program_outcomes_cpo`
--
ALTER TABLE `program_outcomes_cpo`
  ADD CONSTRAINT `fk_cpo_po` FOREIGN KEY (`po_id`) REFERENCES `program_outcomes` (`po_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_outcomes_cpo_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `program_outcomes` (`po_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_outcomes_cpo_ibfk_2` FOREIGN KEY (`cpo_id`) REFERENCES `cpo` (`cpo_id`) ON DELETE CASCADE;

--
-- Constraints for table `program_outcomes_igo`
--
ALTER TABLE `program_outcomes_igo`
  ADD CONSTRAINT `fk_igo_po` FOREIGN KEY (`po_id`) REFERENCES `program_outcomes` (`po_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_outcomes_igo_ibfk_1` FOREIGN KEY (`po_id`) REFERENCES `program_outcomes` (`po_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_outcomes_igo_ibfk_2` FOREIGN KEY (`igo_id`) REFERENCES `igo` (`igo_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
