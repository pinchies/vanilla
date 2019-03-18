/**
 * @copyright 2009-2019 Vanilla Forums Inc.
 * @license GPL-2.0-only
 */

import { useThemeCache, styleFactory, variableFactory } from "@library/styles/styleUtils";
import { globalVariables } from "@library/styles/globalStyleVars";
import { px, important, percent, color } from "csx";
import { shadowHelper } from "@library/styles/shadowHelpers";
import {
    flexHelper,
    margins,
    allLinkStates,
    setAllLinkColors,
    colorOut,
    specific,
    singleBorder,
} from "@library/styles/styleHelpers";
import { lineHeightAdjustment } from "@library/styles/textUtils";

export const richQuoteVariables = useThemeCache(() => {
    const gVars = globalVariables();
    const makeVars = variableFactory("richQuote");

    const title = makeVars("title", {
        size: gVars.fonts.size.subTitle,
        weight: gVars.fonts.weights.bold,
    });

    return { title };
});

export const richQuoteClasses = useThemeCache(() => {
    const vars = richQuoteVariables();
    const gVars = globalVariables();
    const style = styleFactory("richQuote");
    const flex = flexHelper();

    const root = style({});

    const verticalSpacing = 4;

    const frame = style("frame", {
        ...shadowHelper().embed(),
        borderRadius: 4,
        padding: 12,
        maxWidth: 700,
        ...margins({
            top: 0,
            bottom: 0,
            right: "auto",
            left: "auto",
        }),
        position: "relative",
    });
    const header = style("header", {});

    const title = style(
        "title",
        setAllLinkColors({
            default: {
                color: colorOut(gVars.mainColors.fg),
            },
        }),
        {
            display: "block",
            marginTop: 12,
            fontSize: vars.title.size,
            fontWeight: vars.title.weight,
            lineHeight: gVars.lineHeights.condensed,
            marginBottom: verticalSpacing,
        },
    );

    const main = style("main");

    const quote = style("quote", {
        margin: 0,
    });
    const expandButton = style("expandButton", {
        paddingLeft: 0,
        paddingRight: 0,
        width: percent(100),
        textAlign: "left",
    });

    const selectionToggle = style("selectionToggle", {
        position: "absolute",
        top: 12,
        right: 0,
        color: colorOut(gVars.mainColors.primary),
    });

    const selectionToggleIcon = style("selectionToggleIcon", {
        opacity: 1,
        height: 24,
        width: 24,
    });

    const footer = style("footer", {
        borderTop: singleBorder(),
        paddingTop: 12,
        marginTop: 12,
    });

    const resourceLink = style("resourceLink", setAllLinkColors(), flex.middleLeft());
    const resourceText = style("resourceText", setAllLinkColors(), {
        flex: 1,
    });
    const resourceIcon = style("resourceIcon", {
        height: 16,
        width: 16,
        marginRight: 6,
    });

    return {
        root,
        frame,
        main,
        header,
        title,
        quote,
        expandButton,
        selectionToggle,
        footer,
        resourceLink,
        resourceText,
        resourceIcon,
    };
});
