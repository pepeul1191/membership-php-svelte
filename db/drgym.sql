-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-08-2023 a las 22:01:33
-- Versión del servidor: 8.0.33-0ubuntu0.20.04.2
-- Versión de PHP: 7.4.3-4ubuntu2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `drgym`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `body_parts`
--

CREATE TABLE `body_parts` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `body_parts`
--

INSERT INTO `body_parts` (`id`, `name`) VALUES
(1, 'ABDOMEN'),
(2, 'PIERNAS'),
(3, 'PANTORRILLA'),
(4, 'PECTORAL'),
(5, 'ESPALDA'),
(6, 'HOMBROS'),
(7, 'BICEPS'),
(8, 'TRICEPS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `disciplines`
--

INSERT INTO `disciplines` (`id`, `name`) VALUES
(1, 'COMPLETO'),
(2, 'BAILE'),
(3, 'MÁQUINAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exercises`
--

CREATE TABLE `exercises` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `image_url` varchar(60) NOT NULL,
  `video_url` varchar(100) NOT NULL,
  `body_part_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `exercises`
--

INSERT INTO `exercises` (`id`, `name`, `image_url`, `video_url`, `body_part_id`) VALUES
(1, 'Curl con mancuernas', 'uploads/GQAE8IWNpoPnlwHf7c6F.png', 'https://www.youtube.com/shorts/yc4vQ_SZHZo?feature=share', 7),
(2, 'Martillo con mancuernas', 'E', 'https://www.youtube.com/shorts/yc4vQ_SZHZo?feature=share', 7),
(3, 'Caminadora', 'uploads/dyq8jDOaHLtvCFQJYG7m.png', 'https://www.youtube.com/shorts/yc4vQ_SZHZo?feature=share', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levels`
--

CREATE TABLE `levels` (
  `id` int NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'SUPERIOR HOMBRE - PRINCIPIANTE'),
(2, 'SUPERIOR HOMBRE - INTERMEDIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `names` varchar(30) NOT NULL,
  `last_names` varchar(35) NOT NULL,
  `email` varchar(50) NOT NULL,
  `code` varchar(9) NOT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `medical_obs` varchar(70) DEFAULT NULL,
  `discipline_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `members`
--

INSERT INTO `members` (`id`, `names`, `last_names`, `email`, `code`, `phone`, `medical_obs`, `discipline_id`) VALUES
(1, 'José Jesús', 'Valdivia Caballero', 'pepe.valdivia.caballero@gmail.com', 'XD-9773', '190839012', 'Espondilitis Anquilosante hace 20 años', 2),
(2, 'Yacky', 'Rmirez', 'yacky@gmail.com', 'XD-9774', '19083903', 'Es espesa nomas', 1),
(4, 'Sila', 'Esculapia', 'sila@gmail.com', 'alskdjf', '123123', 'bb', 2),
(5, 'al', 'klasj', 'asdf@gmail.com', 'asdf', '123123', 'aslkdfj', 1),
(6, '1312asd', 'asdaaa', 'asd2f@gmail.com', '1', '13123123', 'asdfadsf', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memberships`
--

CREATE TABLE `memberships` (
  `id` int NOT NULL,
  `beginning` date NOT NULL,
  `ending` date NOT NULL,
  `member_id` int DEFAULT NULL,
  `membership_state_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `memberships`
--

INSERT INTO `memberships` (`id`, `beginning`, `ending`, `member_id`, `membership_state_id`) VALUES
(1, '2023-08-21', '2023-08-25', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `membership_states`
--

CREATE TABLE `membership_states` (
  `id` int NOT NULL,
  `name` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `membership_states`
--

INSERT INTO `membership_states` (`id`, `name`) VALUES
(1, 'ACTIVO'),
(2, 'SUSPENDIDO'),
(3, 'VENCIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `members_objectives`
--

CREATE TABLE `members_objectives` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `objective_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `members_objectives`
--

INSERT INTO `members_objectives` (`id`, `member_id`, `objective_id`) VALUES
(2, 1, 1),
(3, 1, 2),
(4, 6, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objectives`
--

CREATE TABLE `objectives` (
  `id` int NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `objectives`
--

INSERT INTO `objectives` (`id`, `name`) VALUES
(1, 'BAJAR DE PESO'),
(2, 'AUMENTAR MASA MUSCULAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `name` varchar(60) NOT NULL,
  `membership_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `packages`
--

INSERT INTO `packages` (`id`, `name`, `membership_id`) VALUES
(1, 'Jueves Piernas', 1),
(2, 'viernes espalda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packages_exercises`
--

CREATE TABLE `packages_exercises` (
  `id` int NOT NULL,
  `position` int DEFAULT NULL,
  `reps` int DEFAULT NULL,
  `sets` int DEFAULT NULL,
  `package_id` int DEFAULT NULL,
  `exercise_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `packages_exercises`
--

INSERT INTO `packages_exercises` (`id`, `position`, `reps`, `sets`, `package_id`, `exercise_id`) VALUES
(5, 1, 2, 150, 1, 1),
(7, 1, 4, 5, 1, 3),
(8, 1, 3, 2, 1, 2),
(9, 1, 10, 2, 2, 1),
(10, 2, 15, 3, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `version` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `schema_migrations`
--

INSERT INTO `schema_migrations` (`version`) VALUES
('20230407222653'),
('20230407234751'),
('20230408000606'),
('20230408000607'),
('20230408000648'),
('20230408000659'),
('20230408002015'),
('20230408002334'),
('20230408002339'),
('20230408020803'),
('20230413035225'),
('20230413035244'),
('20230413035253'),
('20230413035259'),
('20230722011439'),
('20230809144748'),
('20230809145027'),
('20230809145940'),
('20230809151520'),
('20230810174001'),
('20230811011809'),
('20230823024902');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `user` varchar(45) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `reset_key` varchar(20) DEFAULT NULL,
  `activation_key` varchar(25) DEFAULT NULL,
  `state` varchar(12) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `reset_key`, `activation_key`, `state`) VALUES
(1, '', '', '', '', 'PENDING'),
(2, 'adsfds', 'aExQRCtjRnZzYU8xREt2ZFN2SndkQT09', '8dNtWTxr1rSNRHz', '', 'PENDING'),
(3, 'adsfd', 'UTRMTXNnR0xKbGRldG5WR1FhYzltZz09', 'NtxE2Qrq1Y6gND1PNphT', 'q3rzdhxIHEbiQWKxQY6Z', 'PENDING'),
(4, 'admin2', 'Mlp6RGJIWEFqK2JUSEhDaXF6OHlnQT09', 'v6qLAICHPAA1mvz7H815', 'xYA8xQOKbZQ4kamRmfvb', 'PENDING'),
(5, 'adsfd3', '', 'l3jEF2G4RVVClnP', '2nLXrx3OgDp5I4FJoS9D', 'PENDING');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_members`
--

CREATE TABLE `users_members` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users_members`
--

INSERT INTO `users_members` (`id`, `user_id`, `member_id`) VALUES
(1, 2, 4),
(2, 3, 5),
(3, 4, 2),
(4, 5, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `body_parts`
--
ALTER TABLE `body_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `body_part_id` (`body_part_id`);

--
-- Indices de la tabla `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discipline_id` (`discipline_id`);

--
-- Indices de la tabla `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `fk_memberships_membership_states` (`membership_state_id`);

--
-- Indices de la tabla `membership_states`
--
ALTER TABLE `membership_states`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `members_objectives`
--
ALTER TABLE `members_objectives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `objective_id` (`objective_id`);

--
-- Indices de la tabla `objectives`
--
ALTER TABLE `objectives`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `membership_id` (`membership_id`);

--
-- Indices de la tabla `packages_exercises`
--
ALTER TABLE `packages_exercises`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `exercise_id` (`exercise_id`);

--
-- Indices de la tabla `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users_members`
--
ALTER TABLE `users_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `body_parts`
--
ALTER TABLE `body_parts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `exercises`
--
ALTER TABLE `exercises`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `membership_states`
--
ALTER TABLE `membership_states`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `members_objectives`
--
ALTER TABLE `members_objectives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `objectives`
--
ALTER TABLE `objectives`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `packages_exercises`
--
ALTER TABLE `packages_exercises`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users_members`
--
ALTER TABLE `users_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `exercises`
--
ALTER TABLE `exercises`
  ADD CONSTRAINT `exercises_ibfk_1` FOREIGN KEY (`body_part_id`) REFERENCES `body_parts` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `memberships`
--
ALTER TABLE `memberships`
  ADD CONSTRAINT `fk_memberships_membership_states` FOREIGN KEY (`membership_state_id`) REFERENCES `membership_states` (`id`),
  ADD CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `members_objectives`
--
ALTER TABLE `members_objectives`
  ADD CONSTRAINT `members_objectives_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `members_objectives_ibfk_2` FOREIGN KEY (`objective_id`) REFERENCES `objectives` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`membership_id`) REFERENCES `memberships` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `packages_exercises`
--
ALTER TABLE `packages_exercises`
  ADD CONSTRAINT `packages_exercises_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `packages_exercises_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users_members`
--
ALTER TABLE `users_members`
  ADD CONSTRAINT `users_members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_members_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
