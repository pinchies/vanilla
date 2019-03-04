/*
 * @author Stéphane LaFlèche <stephane.l@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { globalVariables } from "@library/styles/globalStyleVars";
import { absolutePosition, componentThemeVariables, debugHelper, unit } from "@library/styles/styleHelpers";
import { style } from "typestyle";
import { layoutVariables } from "@library/styles/layoutStyles";
import { percent } from "csx";
import memoize from "lodash/memoize";

export const subcommunityListVariables = memoize(() => {
    const themeVars = componentThemeVariables("subcommunityList");
    const globalVars = globalVariables();
    const spacing = {
        padding: 24,
        ...themeVars.subComponentStyles("spacing"),
    };

    const sizing = {
        width: 432,
        ...themeVars.subComponentStyles("sizing"),
    };

    return { spacing, sizing };
});

export const subcommunityListClasses = memoize(() => {
    const globalVars = globalVariables();
    const vars = subcommunityListVariables();
    const debug = debugHelper("subcommunityList");
    const mediaQueries = layoutVariables().mediaQueries();

    const root = style(
        {
            padding: unit(vars.spacing.padding),
            ...debug.name(),
        },
        mediaQueries.oneColumn({
            padding: 0,
        }),
    );

    const items = style(
        {
            position: "relative",
            display: "flex",
            flexWrap: "wrap",
            alignItems: "stretch",
            justifyContent: "space-between",
            ...debug.name("items"),
        },
        mediaQueries.oneColumn({
            display: "block",
        }),
    );

    const item = style(
        {
            display: "flex",
            flexDirection: "column",
            alignItems: "center",
            justifyContent: "stretch",
            width: unit(vars.sizing.width),
            ...debug.name("item"),
        },
        mediaQueries.oneColumn({
            display: "block",
            width: percent(100),
        }),
    );

    return { root, items, item };
});
