/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";

// Base interface for themeable components.
export interface IThemeable {
    className?: string;
    as?: keyof JSX.IntrinsicElements;
    children?: React.ReactNode;
}
