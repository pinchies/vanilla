/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import React from "react";
import { metasClasses } from "@library/content/meta/metasStyles";
import { IThemeable } from "@library/styles/themeUtils";
import classNames from "classnames";

export function MetaText(props: IProps) {
    const classes = metasClasses();
    const Tag = props.as || "span";

    return <Tag className={classNames(classes.meta, props.className)}>{props.children}</Tag>;
}

interface IProps extends IThemeable {}
