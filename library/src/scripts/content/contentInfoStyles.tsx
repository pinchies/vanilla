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

export const contentInfoVariables = useThemeCache(() => {
    const gVars = globalVariables();
    const makeVars = variableFactory("contentInfo");

    const photo = makeVars("sizing", {
        size: px(32),
        radius: 100,
    });

    return { photo };
});

export const contentInfoClasses = useThemeCache(() => {
    const vars = contentInfoVariables();
    const gVars = globalVariables();
    const style = styleFactory("contentInfo");
    const flex = flexHelper();
    const root = style(flex.middleLeft(), {});
    const info = style("info", {});

    const userPhotoContainer = style("userPhotoContainer", flex.middle());
    const userPhoto = style(
        "userPhoto",
        setAllLinkColors({
            default: {
                color: colorOut(gVars.mainColors.fg),
            },
        }),
        {
            height: vars.photo.size,
            width: vars.photo.size,
            borderRadius: vars.photo.radius,
            marginRight: 12,
        },
    );
    const nameLine = style("nameLine", {});
    const userName = style(
        "userLink",
        setAllLinkColors({
            default: {
                color: colorOut(gVars.elementaryColors.black),
            },
        }),
        {
            fontSize: gVars.fonts.size.medium,
            fontWeight: gVars.fonts.weights.semiBold,
        },
    );

    return {
        root,
        info,
        userPhoto,
        userPhotoContainer,
        nameLine,
        userName,
    };
});
