/*
 * @author Stéphane LaFlèche <stephane.l@vanillaforums.com>
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { globalVariables } from "@library/styles/globalStyleVars";
import { styleFactory, useThemeCache, variableFactory } from "@library/styles/styleUtils";
import { allLinkStates, colorOut, margins, unit, paddings, borders } from "@library/styles/styleHelpers";
import { calc, ColorHelper } from "csx";
import { NestedCSSProperties } from "typestyle/lib/types";

export const metasVariables = useThemeCache(() => {
    const globalVars = globalVariables();
    const makeThemeVars = variableFactory("metas");

    const fonts = makeThemeVars("fonts", {
        size: globalVars.fonts.size.small,
    });

    const colors = makeThemeVars("color", {
        fg: globalVars.mixBgAndFg(0.85),
        hover: {
            fg: globalVars.links.colors.active,
        },
        focus: {
            fg: globalVars.links.colors.active,
        },
        active: {
            fg: globalVars.links.colors.active,
        },
        deleted: globalVars.feedbackColors.deleted,
    });

    const text = makeThemeVars("text", {
        margin: 4,
        lineHeight: globalVars.lineHeights.base,
    });

    const spacing = makeThemeVars("spacing", {
        verticalMargin: 24,
        default: globalVars.gutter.quarter,
    });

    return {
        fonts,
        colors,
        text,
        spacing,
    };
});

export const metasClasses = useThemeCache(() => {
    const vars = metasVariables();
    const globalVars = globalVariables();
    const style = styleFactory("frame");

    const root = style({
        display: "block",
        lineHeight: globalVars.lineHeights.meta,
        color: colorOut(vars.colors.fg),
        width: calc(`100% + ${vars.spacing.default * 2}`),
        overflow: "hidden",
        textAlign: "left",
        ...margins({
            left: -vars.spacing.default,
            right: vars.spacing.default,
        }),
        $nest: {
            a: {
                ...allLinkStates({
                    allStates: {
                        textShadow: "none",
                    },
                    noState: {
                        color: colorOut(vars.colors.fg),
                    },
                    hover: {
                        color: colorOut(vars.colors.hover.fg),
                    },
                    focus: {
                        color: colorOut(vars.colors.focus.fg),
                    },
                    active: {
                        color: colorOut(vars.colors.active.fg),
                    },
                }),
            },
            "&.isFlexed": {
                display: "flex",
                flexWrap: "wrap",
                justifyContent: "flex-start",
                alignItems: "center",
            },
        },
    });

    const metaMixin: NestedCSSProperties = {
        display: "inline-block",
        fontSize: unit(vars.fonts.size),
        color: colorOut(vars.colors.fg),
        lineHeight: globalVars.lineHeights.meta,
    };

    const metaMargins = margins({
        top: 0,
        right: vars.spacing.default,
        bottom: 0,
        left: vars.spacing.default,
    });

    const meta = style("meta", metaMixin, metaMargins, {
        $nest: {
            "& &": {
                margin: 0,
            },
        },
    });

    // Get styles of meta, without the margins
    const metaStyle = style("metaStyles", metaMixin);

    const makeTagStyle = (tagColor: ColorHelper) =>
        style(
            "metaTag",
            metaMixin,
            paddings({
                left: 3,
                right: 3,
                top: 2,
                bottom: 2,
            }),
            borders({ color: tagColor, radius: 3 }),
            {
                display: "inline-block",
                whiteSpace: "nowrap",
                color: colorOut(tagColor),
            },
        );

    const metaTag = makeTagStyle(vars.colors.fg);
    const metaTagPrimary = makeTagStyle(globalVars.mainColors.primary);

    return {
        root,
        meta,
        metaStyle,
        metaTag,
        metaTagPrimary,
    };
});
